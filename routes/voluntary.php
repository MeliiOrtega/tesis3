<?php
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\VoluntaryCourses;
use App\Http\Controllers\Voluntary\CourseController;
use App\Http\Livewire\Voluntary\CoursesCurriculum;
use App\Http\Livewire\Voluntary\CoursesStudents;

//!RECORDAR INSTRUCTOR ES VOLUNTARY
//*RECORDAR INSTRUCTOR ES VOLUNTARY
/* Route::get('courses', VoluntaryCourses::class)->middleware('can:Leer actividad')->name('courses.index');
*/
Route::redirect('', 'voluntary/courses');

Route::resource('courses', CourseController::class)->names('courses');

Route::get('courses/{course}/curriculum', CoursesCurriculum::class)->middleware('can:Actualizar Actividades')->name('courses.curriculum');

Route::get('courses/{course}/goals', [CourseController::class, 'goals'])->name('courses.goals');

Route::get('courses/{course}/students', CoursesStudents::class)->middleware('can:Actualizar Actividades')->name('courses.students');

Route::post('courses/{course}/status', [CourseController::class, 'status'])->name('courses.status');
