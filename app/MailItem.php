<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailItem extends Model
{
    protected $connection = 'mysql3';
    public $timestamps = false;
    protected $table = 'mail_items';
}
