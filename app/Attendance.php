<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = [];

    public function studentAttendance() {
        return $this->belongsTo('App\Student' , 'student_id' , 'id');
    }

    public function subjectUserAttendance()
    {
        return $this->belongsTo('App\Subject_User', 'subject_user_id' , 'id');
    }

}
