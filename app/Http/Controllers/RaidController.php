<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Raid;
use App\RaidCategory;
use App\ReserveItem;
use App\Signup;
use App\Character;
use App\Setting;

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
        $raids = $this->getRaids();
        $settings = Setting::where('guildID', $server->id)->first();
        if (empty($settings)) {
            $settings = new Setting;
        }

        return view('raids.manage')
        ->with('server', $server)
        ->with('channel', $channel)
        ->with('raid', $raid)
        ->with('raids', $raids)
        ->with('settings', $settings);
    }

    public function postSave(Request $request) {
        // Populate our save array
        $user = session()->get('user');
        $raidID = $request->raidID;
        $saveData = [
            'raid' => $request->raid,
            'channel' => $request->channel,
            'name' => $request->title,
            'title' => $request->title,
            'date' => date('Y-m-d', strtotime($request->date)),
            'time' => $request->time,
            'description' => $request->description,
            'confirmation' => $request->confirmation,
            'softreserve' => $request->softreserve,
            'color' => $request->color ?: '#FF9900',
            'memberID' => $user->id,
            'id' => $raidID,
            'guildID' => $request->guildID,
            'faction' => $request->faction
        ];

        $raid = new Raid();
        if ($raidID) {
            return $raid->updateRaid($raidID, $saveData);
        } else {
            return $raid->createRaid($saveData);
        }
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

    public function new($serverID = 0) {
        $servers = $serverID ? [] : session()->get('guilds');
        $guilds = [];
        foreach ($servers AS $guild) {
            $guilds[$guild->id] = $guild;
        }
        $settings = Setting::where('guildID', $serverID)->first();
        if (empty($settings)) {
            $settings = new Setting;
        }
        $server = $serverID ? $this->getServer($serverID) : null;;
        return view('raids.new')
            ->with('raid', New Raid())
            ->with('raids', $this->getRaids())
            ->with('channel', null)
            ->with('server', $server)
            ->with('guilds', $guilds)
            ->with('settings', $settings);
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
        if ($type == 'dupe') {
            $this->sendMessage(0, $raid->channelID, '+dupe');
        }
        if ($type == 'archive') {
            $this->sendMessage(0, $raid->channelID, '+archive');
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

    public function userRoles($user, $guildID) {
        $guildMember = $this->botRequest('/guilds/' . $guildID . '/members/' . $user->id);
        $roles = $this->botRequest('/guilds/' . $guildID . '/roles');
        $roleArray = [];
        foreach ($roles AS $role) {
            $roleArray[$role->id] = $role;
        }
        $userRoles = [];
        foreach ($guildMember->roles AS $role) {
            $userRoles[$role] = $roleArray[$role];
        }
        return $userRoles;
    }



    public function getRaids() {
        $raids = [
            'Classic' => ['mc' => 'Molten Core', 'ony' => 'Onyxia', 'bwl' => 'Blackwing Lair', 'zg' => 'Zul\'Gurub', 'aq40' => 'Temple of Ahn\'Qiraj', 'aq20' => 'Ruins of Ahn\'Qiraj', 'naxx' => 'Naxxramas'],
            'Burning Crusade' => ['kara' => 'Karazhan', 'gl' => 'Gruul\'s Lair', 'ssc' => 'Serpentshrine Cavern', 'tk' => 'Tempest Keep', 'bt' => 'Black Temple', 'sw' => 'Sunwell']
        ];
        return $raids;
    }

}