<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class HomeController extends Controller
{
    public function __invoke(){
        $courses = Course::where('status','3')->latest('id')->get()->take(12);
       // return $courses;
        /* metodo latest ordena en forma descente
        */
     // return Course::find(2)->rating;
       return view('welcome', compact('courses'));
    }

}
