<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Character;

class CharacterController extends Controller
{
    public function index()
    {
        $servers = session()->get('guilds');
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
        $nick = property_exists($currentServer->member, 'nick') ? $currentServer->member->nick : null;
        $characters = [];
        if (!empty($nick)) {
            $main = Character::where('name', $nick)
            ->where('guildID', $currentServer->id)
            ->first();
            if (!empty($main)) {
                $characters[] = $main;
                $alts = Character::where('mainID', $main->id)->get();
                foreach ($alts as $alt) {
                    $characters[] = $alt;
                }
            }
        }

        return view('characters.server')
        ->with('server', $currentServer)
        ->with('characters', $characters);
    }


}