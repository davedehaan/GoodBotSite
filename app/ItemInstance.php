<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemInstance extends Model
{
    protected $connection = 'mysql3';
    public $timestamps = false;
    protected $table = 'item_instance';
}
