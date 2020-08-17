<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['faction', 'server', 'region', 'sheet', 'welcomeMessage', 'guildID'];
    protected $table = 'settings';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

}
