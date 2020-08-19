<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signup extends Model
{
    protected $table = 'signups';
    protected $fillable = ['name', 'confirmed'];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function Raid()
    {
        return $this->belongsTo('App\Raid', 'raidID', 'id');
    }

    public function Reserve()
    {
        return $this->hasOne('App\RaidReserve', 'signupID', 'id');
    }

}
