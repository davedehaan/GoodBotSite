<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signup extends Model
{
    protected $table = 'signups';

    public function Raid()
    {
        return $this->belongsTo('App\Raid', 'raidID', 'id');
    }

    public function Reserve()
    {
        return $this->hasOne('App\RaidReserve', 'signupID', 'id');
    }

}
