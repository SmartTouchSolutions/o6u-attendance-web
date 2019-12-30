<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject_User extends Model
{
    protected $guarded = [];

       return $this->hasOne('App\subject', 'foreign_key');

}
