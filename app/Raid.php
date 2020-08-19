<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Raid extends Model
{
    protected $table = 'raids';
    protected $fillable = ['name', 'title', 'raid', 'description', 'confirmation', 'softreserve'];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function Signups() 
    {
        return $this->hasMany('App\Signup', 'raidID', 'id');
    }
}
