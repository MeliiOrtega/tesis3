<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Course;
class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function enrolled(User $user, Course $course){ //PARA CONOCER SI ESTA REGISTRADO
        return $course->students->contains($user->id);
    }


    public function published(?User $user, Course $course){
        if ($course->status == 3) {
            return true;
        }
        else{
            return false;
        }
    }

    public function dicatated(User $user, Course $course){
        if($course->user == 2){
            return true;
        }else
            return false;
    }
}

