<?php

namespace App;

use App\BaseModel;

class Signup extends BaseModel
{
    protected $table = 'signups';
    protected $fillable = ['name', 'confirmed', 'raidID', 'signup', 'player', 'channelID', 'guildID', 'memberID'];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function Raid()
    {
        return $this->belongsTo('App\Raid', 'raidID', 'id');
    }

    public function Character()
    {
        return $this->belongsTo('App\Character', 'characterID', 'id');
    }

    public function Reserve()
    {
        return $this->hasOne('App\RaidReserve', 'signupID', 'id');
    }

}
