<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Raid extends Model
{
    protected $table = 'raids';

    public function Signups() 
    {
        return $this->hasMany('App\Signup', 'raidID', 'id');
    }
}
