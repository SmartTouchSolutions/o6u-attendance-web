<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject_Student extends Model
{
    protected $guarded = [];
    protected $table = 'subject_students';

//    public function subjectUser() {
//        return $this->belongsTo('App\Subject_User');
//    }

}
