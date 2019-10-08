<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Place extends Model
{
    protected $table = 'places';

    public function place(){
        return $this->hasMany('App\User', 'id');
    }
}
