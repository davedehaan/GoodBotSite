<?php

use Illuminate\Http\Request;
use App\Raid;
use App\Signup;
use App\Http\Resources\Signup AS SignupResource;
use App\Http\Resources\Raid AS RaidResource;
use App\Http\Resources\RaidFull AS RaidFullResource;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/raids/{guildID}', function($guildID) {
    $raids = Raid::where('guildID', $guildID)
        ->where('date', '>', date('Y-m-d, h:i:s'))
        ->get();

    return RaidResource::collection($raids);
});

Route::get('/raid/{raidID}', function($raidID) {
    $raid = Raid::with(['signups', 'signups.reserve.item'])
        ->find($raidID);
    
    return new RaidFullResource($raid);
});


Route::get('/signups/member/{memberID}', function($memberID) {
    $signups = Signup::where('memberID', $memberID)
        ->with(['raid', 'reserve', 'reserve.item'])
        ->get();

    return SignupResource::collection($signups);
});

Route::get('/signups/name/{name}/{guildID}', function($name, $guildID) {
    $signups = Signup::where('player', $name)
        ->where('guildID', $guildID)
        ->with(['raid', 'reserve', 'reserve.item'])
        ->get();

    return SignupResource::collection($signups);
});

