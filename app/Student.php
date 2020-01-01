<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

//   public function Subjects()
//    {
//        return $this->belongsToMany('App\Subject', 'subject_students', 'student_id', 'subject_user_id');
//    }

public function subjectStudent() {
    return $this->hasMany('App\Subject_Student');
}



    public  function attendances(){
       return $this->hasMany('App\Attendance', 'student_id', 'id');
    }

}
