<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RaidReserve extends Model
{
    protected $table = 'raid_reserves';

    public function Item()
    {
        return $this->hasOne('App\ReserveItem', 'id', 'reserveItemID');
    }
}
