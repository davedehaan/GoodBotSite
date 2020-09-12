<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

}
