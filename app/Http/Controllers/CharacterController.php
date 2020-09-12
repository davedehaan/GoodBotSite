<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Character;
use App\Setting;

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
        $currentServer = $this->getServer($serverID, false);
        $settings = Setting::where('guildID', $serverID)->first();
        $this->goodBotInstalled($serverID);
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
        ->with('nick', $this->getNick($serverID))
        ->with('server', $currentServer)
        ->with('characters', $characters)
        ->with('classes', $classes)
        ->with('roles', $roles)
        ->with('settings', $settings);
    }

    public function save($serverID, $characterID) {
        // Retrieve the character name from the query
        $name = ucfirst(strtolower(request()->query('name')));
        // Retrieve the user's nickname on this server
        $nick = $this->getNick($serverID);
        // Retrieve the user's main on this server
        $main = $this->getMain($serverID);

        // 
        if ($name != $nick && empty($characterID) && empty($main)) {
            $result = $this->setNick($serverID, $name, true);
            if (is_object($result) && $result->code == 50013) {
                die('The bot could not automatically change your name due to permissions issues.  It must have a higher role within roles than the person it is trying to change.  Please note that it can never change the nickname of an administrator.<br />Please fix the permission issue, or manually change your name to "' . $name . '" and try again.');
            }
        }
        $class = request()->query('class');
        $role = request()->query('role');
        $record = [
            'name' => $name,
            'class' => $class,
            'role' => $role,
            'memberID' => session()->get('user')->id
        ];
        // We couldn't find their main -- this must be it!
        if (empty($characterID)) {
            $record['guildID'] = $serverID;
            if ($main) {
                $record['mainID'] = $main->id;
            }
            Character::create($record);
        } else {
            if ($main->id == $characterID && $main->name != $name) {
                $result = $this->setNick($serverID, $name, true);
                if (is_object($result) && $result->code == 50013) {
                    die('The bot could not automatically change your name due to permissions issues.  It must have a higher role within roles than the person it is trying to change.  Please note that it can never change the nickname of an administrator.<br />Please fix the permission issue, or manually change your name to "' . $name . '" and try again.');
                }
            }
            Character::where('id', $characterID)->update($record);
        }
        return redirect()->route('character.list', ['serverID' => $serverID]);
    }

    public function setNick($serverID, $nick) {
        $user = session()->get('user');
        $url = '/guilds/' . $serverID . '/members/' . $user->id;
        $request = $this->botRequest($url, ['nick' => $nick], true);
        return $request;
    }

    public function getNick($serverID) {
        $user = session()->get('user');
        $userInfo = $this->botRequest('/guilds/' . $serverID . '/members/' . $user->id);
        $nick = null;
        if (property_exists($userInfo, 'user')) {
            $nick = property_exists($userInfo, 'nick') && !empty($userInfo->nick) ? $userInfo->nick : $userInfo->user->username;
        }
        return $nick;
    }

    public function getMain($serverID) {
        $nick = $this->getNick($serverID);

        if (!empty($nick)) {
            $main = Character::where('name', $nick)
                ->where('guildID', $serverID)
                ->first();
            return $main;
        }
        return false;
    }
}