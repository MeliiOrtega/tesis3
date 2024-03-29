<?php

namespace App\Http\Livewire\Voluntary;


use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CoursesStudents extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public $course, $search;


    public function mount(Course $course){
        $this->course = $course;
        $this->authorize('dicatated', $course);
    }

    public function updatingSearch(){
        $this->resetPage();
    }


    public function render()
    {
        $students = $this->course->students()->where('name', 'LIKE', '%' . $this->search . '%')->paginate(4);
        return view('livewire.voluntary.courses-students', compact('students'))->layout('layouts.voluntary', ['course'=> $this->course]);
    }
}
