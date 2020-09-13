<?php

use Illuminate\Http\Request;
use App\Raid;
use App\Signup;
use App\Character;
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

Route::middleware(['api'])->group(function() {
    Route::get('/raids', function() {
        $guildID = request()->get('access')->guildID;
        $raids = Raid::where('guildID', $guildID)
            ->where('date', '>', date('Y-m-d, h:i:s'))
            ->get();
    
        return RaidResource::collection($raids);
    });
    
    Route::get('/raid/{raidID}', function($raidID) {
        $guildID = request()->get('access')->guildID;
        $raid = Raid::with(['signups', 'signups.reserve.item'])
            ->where('guildID', $guildID)
            ->find($raidID);
        
        return new RaidFullResource($raid);
    });
    
    
    Route::get('/signups', function(Request $request) {
        $memberID = $request->get('access')->memberID;
        $signups = Signup::where('memberID', $memberID)
            ->whereHas('raid', function($q) {
                $q->where('date', '>', date('Y-m-d, h:i:s'));
            })
            ->with(['raid', 'reserve', 'reserve.item'])
            ->get();

        return SignupResource::collection($signups);
    });
    
    Route::get('/signups/{name}', function($name) {
        $guildID = request()->get('access')->guildID;
        $signups = Signup::where('player', $name)
            ->where('guildID', $guildID)
            ->whereHas('raid', function($q) {
                $q->where('date', '>', date('Y-m-d, h:i:s'));
            })
            ->with(['raid', 'reserve', 'reserve.item'])
            ->get();
        return SignupResource::collection($signups);
    });

    Route::get('/signup', function(Request $request) {
        $parameters = [
            'raidID'        => $request->get('raidID'),
            'characterID'   => $request->get('characterID'),
            'signup'        => $request->get('signup')
        ];
        foreach ($parameters AS $key => $value) {
            if (empty($value)) {
                return ['error' => $key . ' is a required parameter.'];
            }
        }
        $raid       = Raid::findOrFail($parameters['raidID']);
        $character  = Character::findOrFail($parameters['characterID']);
        $signup     = Signup::updateOrCreate(
            [
                'raidID' => $parameters['raidID'], 
                'player' => $character->name,
            ],
            [
                'signup' => $parameters['signup'],
                'channelID' => $raid->channelID,
                'guildID' => $raid->guildID,
                'memberID' => $request->id
            ]);
        
            // Create the embed
        $signup->sendMessage(0, $raid->channelID, '+embed refresh');

        return ['success' => $signup];

    });
  
});