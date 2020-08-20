<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Raid;
use App\ReserveItem;
use App\Signup;
use App\Character;

class RaidController extends Controller
{
    public function index() {
        $user = session()->get('user');
        $servers = session()->get('guilds');
        $guilds = [];
        foreach ($servers AS $server) {
            $guilds[$server->id] = $server;
        }
        $raids = Raid::where('memberID', $user->id)
            ->where('date', '>=', date('Y-m-d'))
            ->where('date', '<', date('Y-m-d', strtotime('+90 days')))
            ->get();
        return view('raids.index')
            ->with('guilds', $guilds)
            ->with('raids', $raids);
    }

    public function lineup($raidID) {
        $raid = $this->getRaid($raidID);
        $signups = Signup::where('raidID', $raidID)->get();
        $characters = $this->getCharacters($signups, $raid->guildID);
        $crosspostChararacters = $this->getCharacters($signups, $raid->crosspostID);
        foreach ($signups AS $signup) {
            if (array_key_exists($signup->player, $characters)) {
                $signup->role = $characters[$signup->player]->role;
                $signup->class = $characters[$signup->player]->class;
            } else if (array_key_exists($signup->player, $crosspostChararacters)) {    
                $signup->role = $crosspostChararacters[$signup->player]->role;
                $signup->class = $crosspostChararacters[$signup->player]->class;
            } else {
                $signup->role = 'unknown';
                $signup->class = 'unknown';
            }
        }
        return view('raids.lineup')
            ->with('raid', $raid)
            ->with('signups', $signups);
    }

    public function reserves($raidID)
    {
        $this->getRaid($raidID);
        $raid = Raid::with(['signups', 'signups.reserve', 'signups.reserve.item'])->where('id', $raidID)->first();
        $items = ReserveItem::where('raid', $raid->raid)->orderBy('name')->get();
        
        return view('raids.reserves')
        ->with('raid', $raid)
        ->with('items', $items);
    }

    public function manage($raidID) {
        $raid = $this->getRaid($raidID);
        $channel = $this->botRequest('/channels/' . $raid->channelID);
        $server = $this->getServer($raid->guildID, false);

        $raids = [
            'Classic' => ['mc' => 'Molten Core', 'ony' => 'Onyxia', 'bwl' => 'Blackwing Lair', 'zg' => 'Zul\'Gurub', 'aq40' => 'Temple of Ahn\'Qiraj', 'aq20' => 'Ruins of Ahn\'Qiraj', 'naxx' => 'Naxxramas'],
            'Burning Crusade' => ['kara' => 'Karazhan', 'gl' => 'Gruul\'s Lair', 'ssc' => 'Serpentshrine Cavern', 'tk' => 'Tempest Keep', 'bt' => 'Black Temple', 'sw' => 'Sunwell']
        ];

        return view('raids.manage')
        ->with('server', $server)
        ->with('channel', $channel)
        ->with('raid', $raid)
        ->with('raids', $raids);
    }

    public function postManage(Request $request, $raidID) {
        $raid = $this->getRaid($raidID);
        $server = $this->getServer($raid->guildID, false);

        $channel = $this->botRequest('/channels/' . $raid->channelID);
        if ($channel->name != $request->channel) {
            $result = $this->botRequest('/channels/' . $raid->channelID, ['name' => $request->channel], true);
            print_r($result);
            exit;
        }

        Raid::where('id', $raidID)
            ->update([
                'raid' => $request->raid,
                'title' => $request->title,
                'date' => date('Y-m-d', strtotime($request->date)),
                'description' => $request->description,
                'confirmation' => $request->confirmation,
                'softreserve' => $request->softreserve
            ]);

        // Refresh our embed
        $this->sendMessage(0, $raid->channelID, '+embed refresh');
        return back();
    }

    public function confirm($raidID, $signupID) {
        $raid = $this->getRaid($raidID);
        Signup::where('id', $signupID)
            ->update(['confirmed' => 1]);
    }

    public function unconfirm($raidID, $signupID) {
        $raid = $this->getRaid($raidID);
        Signup::where('id', $signupID)
            ->update(['confirmed' => 0]);
    }

    public function new() {
        $guilds = request()->get('guilds');
        return view('raids.new')
            ->with('guilds');
    }

    public function command($raidID, $type) {
        $raid = $this->getRaid($raidID);
        if ($type == 'pingall') {
            $this->sendMessage(0, $raid->channelID, '+pingraid');
        }
        if ($type == 'pingconfirmed') {
            $this->sendMessage(0, $raid->channelID, '+ping confirmed');
        }
        if ($type == 'pingnoreserve') {
            $this->sendMessage(0, $raid->channelID, '+noreserve');
        }
        if ($type == 'pingunsigned') {
            $this->sendMessage(0, $raid->channelID, '+unsigned');
        }

        return back();
    }

    public function getRaid($raidID) {
        $user = session()->get('user');
        $raid = Raid::findOrFail($raidID);
        if ($raid->memberID != $user->id) {
            abort(404);
        }
        return $raid;
    }

    public function getCharacters($signups, $guildID) {
        $list = [];
        foreach ($signups AS $signup) {
            $list[] = $signup->player;
        }

        $characters = Character::where('guildID', $guildID)
            ->whereIn('name', $list)
            ->get();
        
        $characterList = [];
        foreach ($characters AS $character) {
            $characterList[$character->name] = $character;
        }
        
        return $characterList;
    }

}