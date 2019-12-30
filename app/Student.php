<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

   public function Subjects()
    {
        return $this->belongsToMany('App\Subject', 'subject_students', 'student_id', 'subject_user_id');
    }

}
