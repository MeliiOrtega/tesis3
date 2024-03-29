<?php

namespace App\Http\Livewire\Voluntary;

use Livewire\Component;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CoursesCurriculum extends Component
{
    use AuthorizesRequests;

    public $course , $section, $name;

    protected $rules = [
        'section.name' => 'required'
    ];

    public function mount(Course $course){
        $this->course = $course;
        $this->section = new Section();
        $this->authorize('dicatated', $course);
    }

    public function render()
    {
        return view('livewire.voluntary.courses-curriculum')->layout('layouts.voluntary', ['course'=> $this->course]);
    }

    public function edit(Section $section){
        $this->section = $section;
    }

    public function store(){
        $this->validate([
            'name' => 'required'
        ]);
        Section::create([
            'name' => $this->name,
            'course_id' => $this->course->id
        ]);

        $this->reset('name');
        $this->course = Course::find($this->course->id);
    }

    public function update(){
        //ELIMINAR Y TRATAR DE ACTUALIZAR - CAMPO REQUERIDO DE SECTION
        $this->validate();

        $this->section->save();
        $this->section = new Section();

        $this->course = Course::find($this->course->id);

    }

    public function destroy(Section $section){
        $section->delete();
        $this->course = Course::find($this->course->id);

    }


}
