<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Raid;
use App\RaidReserve;
use App\RaidHash;
use App\Signup;

class GoodBotController extends Controller
{
    public function index($raidName)
    {

        $hash = RaidHash::where('hash', $raidName)->first();
        if (!$hash) {
            abort(404);
        }
        $raids = Raid::where('memberID', $hash->memberID)
            ->where('guildID', $hash->guildID)
            ->where('date', '>', date('Y-m-d, h:i:s'))
            ->where('date', '<', date('Y-m-d, h:i:s', strtotime("+3 Months")))
            ->get();
        return view('goodbot.index')
            ->with('raidName', $raidName)
            ->with('raids', $raids);
    }

    public function signups($id)
    {
        $raid = Raid::findOrFail($id);
        $hash = RaidHash::where('memberID', $raid->memberID)
            ->where('guildID', $raid->guildID)
            ->first();
        if (!$hash) {
            abort(404);
        }
        $signups = Signup::where('raidID', $id)->get();
        return view('goodbot.signup')
            ->with('hash', $hash)
            ->with('raid', $raid)
            ->with('signups', $signups);
    }

    public function reserves($id)
    {
        $raid = Raid::with(['signups', 'signups.reserve', 'signups.reserve.item'])->where('id', $id)->first();
        $hash = RaidHash::where('memberID', $raid->memberID)
            ->where('guildID', $raid->guildID)
            ->first();
        if (!$hash || !$raid) {
            abort(404);
        }

        
        return view('goodbot.reserves')
        ->with('hash', $hash)
        ->with('raid', $raid)
        ->with('signups', $raid->signups);
    }
}