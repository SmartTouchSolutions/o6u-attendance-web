<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject_User extends Model
{
    protected $guarded = [];
    protected $table = 'subject_users';
    
    public function lectures() {
        
        return $this->hasMany('App\Lecture' , 'subject_user_id' , 'id');
    }
    
    public function subjects() {
        
        return $this->hasOne('App\Subject' , 'id');
    }
    
}
