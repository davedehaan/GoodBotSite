<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Character;

class CharacterController extends Controller
{
    public function index()
    {
        $servers = session()->get('guilds');
        usort($servers, function($a, $b) { return $a->name <=> $b->name; });
        return view('characters.index')
        ->with('servers', $servers);
    }

    public function server($serverID)
    {
        $currentServer = null;
        $servers = session()->get('guilds');
        foreach ($servers AS $server) {
            if ($server->id == $serverID) {
                $currentServer = $server;
            }
        }

        if (empty($currentServer)) {
            abort(404);
        }
        $characters = [];
        $classes = [
            'warrior', 'paladin', 'shaman', 'hunter', 'rogue', 'druid', 'priest', 'warlock', 'mage'
        ];
        $roles = [
            'dps', 'caster', 'tank', 'healer'
        ];
        $main = $this->getMain($currentServer->id);
        if (!empty($main)) {
            $characters[] = $main;
            $alts = Character::where('mainID', $main->id)->get();
            foreach ($alts as $alt) {
                $characters[] = $alt;
            }
        }

        return view('characters.server')
        ->with('server', $currentServer)
        ->with('characters', $characters)
        ->with('classes', $classes)
        ->with('roles', $roles);
    }

    public function save($serverID, $characterID) {
        $name = request()->query('name');
        $class = request()->query('class');
        $role = request()->query('role');
        $record = [
            'name' => $name,
            'class' => $class,
            'role' => $role,
            'memberID' => session()->get('user')->id
        ];

        $main = $this->getMain($serverID);
        if (!$main) {
            abort(404);
        }
        if (empty($characterID)) {
            $record['guildID'] = $serverID;
            $record['mainID'] = $main->id;
            Character::create($record);
        } else {
            Character::where('id', $characterID)->update($record);
        }
        return redirect()->route('character.list', ['serverID' => $serverID]);
    }



    public function getMain($serverID) {
        $user = session()->get('user');
        $userInfo = $this->botRequest('/guilds/' . $serverID . '/members/' . $user->id);
        if (property_exists($userInfo, 'user')) {
            $nick = property_exists($userInfo, 'nickname') ? $userInfo->nickname : $userInfo->user->username;
        }
        if (!empty($nick)) {
            $main = Character::where('name', $nick)
                ->where('guildID', $serverID)
                ->first();
            return $main;
        }
        return false;
    }
}