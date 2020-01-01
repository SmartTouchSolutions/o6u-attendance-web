<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $guarded = [];

    public function subjectUser() {
        return $this->hasOne('App\Subect_User');
    }
}

//   public function Subjects()
//    {
//        return $this->belongsToMany('App\Subject', 'subject_students', 'student_id', 'subject_user_id');
//    }
