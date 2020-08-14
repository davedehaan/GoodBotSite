<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RaidReserve extends Model
{
    protected $table = 'raid_reserves';
    protected $fillable = ['signupID', 'raidID', 'reserveItemID'];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function Item()
    {
        return $this->hasOne('App\ReserveItem', 'id', 'reserveItemID');
    }
}
