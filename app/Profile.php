<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Profile extends Model
{
    protected $table = 'profiles';

    public function profile(){
        return $this->hasMany('App\User', 'id');
    }
}
