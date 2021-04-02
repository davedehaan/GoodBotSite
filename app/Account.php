<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $connection = 'mysql2';
    public $timestamps = false;
    protected $table = 'account';
}
