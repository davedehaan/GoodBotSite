<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Signup;

class Character extends Model
{
    protected $table = 'characters';
    protected $fillable = ['name', 'class', 'role', 'guildID', 'memberID', 'mainID'];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function getSignups() {
        $signups = Signup::where('player', $this->name)
            ->where('guildID', $this->guildID)
            ->whereHas('raid', function($q) {
                $q->where('date', '>=', date('Y-m-d') . ' 00:00:00');
                $q->where('date', '<', date('Y-m-d', strtotime('+2 months')));
            })
            ->with(['raid', 'reserve', 'reserve.item'])
            ->get();
        $signupArray = [];
        foreach ($signups AS $signup) {
            $signupArray[] = $signup;
        }
        usort($signupArray, function ($a, $b) {
            return $a->raid->date > $b->raid->date;
        });
        $this->signups = $signupArray;
        return $this;
    }

}
