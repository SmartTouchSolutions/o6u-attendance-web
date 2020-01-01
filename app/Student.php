<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Student extends Authenticatable
{
	use Notifiable;
    protected $guarded = [];
    protected $table = 'students';

   public function Subjects()
    {
        return $this->belongsToMany('App\Subject', 'subject_students', 'student_id', 'subject_user_id');
    }

}
