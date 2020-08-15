<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $table = 'characters';
    protected $fillable = ['name', 'class', 'role', 'guildID', 'memberID', 'mainID'];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

}
