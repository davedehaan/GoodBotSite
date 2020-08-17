<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Log;
use App\Setting;

class DashboardController extends Controller
{
    public function index() {
        $servers = session()->get('guilds');
        return view('dashboard.index')
            ->with('servers', $servers);
    }

    public function dashboard($serverID) {
        $servers = session()->get('guilds');
        $currentServer = null;
        foreach ($servers AS $server) {
            if ($server->id == $serverID) {
                $currentServer = $server;
            }
        }
        if (empty($currentServer)) {
            abort(404);
        }

        if ($currentServer->permissions != 2147483647) {
            abort(403);
        }

        return view('dashboard.dashboard')
            ->with('server', $currentServer);
    }

    public function logs($serverID) {
        $servers = session()->get('guilds');
        $currentServer = null;
        foreach ($servers AS $server) {
            if ($server->id == $serverID) {
                $currentServer = $server;
            }
        }
        if (empty($currentServer)) {
            abort(404);
        }

        if ($currentServer->permissions != 2147483647) {
            abort(403);
        }

        $page = request()->query('p', 1);

        $logs = Log::where('guildID', $serverID)->orderBy('createdAt', 'DESC')->limit(100)->offset(($page - 1) * 100)->get();
        foreach ($logs AS &$log) {
            $log->event = explode('/', $log->event);
        }

        return view('dashboard.logs')
            ->with('server', $currentServer)
            ->with('logs', $logs)
            ->with('page', $page);
    }

    
    public function options($serverID) {
        $servers = session()->get('guilds');
        $currentServer = null;
        foreach ($servers AS $server) {
            if ($server->id == $serverID) {
                $currentServer = $server;
            }
        }
        if (empty($currentServer)) {
            abort(404);
        }

        if ($currentServer->permissions != 2147483647) {
            abort(403);
        }

        $settings = Setting::where('guildID', $serverID)->first();
        if (empty($settings)) {
            $settings = new Setting;
        }

        $euServerList = ["Amnennar", "Ashbringer", "Auberdine", "Bloodfang", "Celebras", "Chromie", "Dragon's Call", "Dragonfang", "Dreadmist", "Earthshaker", "Everlook", "Finkle", "Firemaw", "Flamegor", "Flamelash", "Gandling", "Gehennas", "Golemagg", "Harbinger of Doom", "Heartstriker", "Hydraxian Waterlords", "Judgement", "Lakeshire", "Lucifron", "Mandokir", "Mirage Raceway", "Mograine", "Nethergarde Keep", "Noggenfogger", "Patchwerk", "Pyrewood Village", "Razorfen", "Razorgore", "Rhok'delar", "Shazzrah", "Skullflame", "Stonespine", "Sulfuron", "Ten Storms", "Transcendence", "Venoxis", "Wyrmthalak", "Zandalar Tribe"];
        $naServerList = ["Anathema", "Arcanite Reaper", "Arugal", "Ashkandi", "Atiesh", "Azuresong", "Benediction", "Bigglesworth", "Blaumeux", "Bloodsail Buccaneers", "Deviate Delight", "Earthfury", "Faerlina", "Fairbanks", "Felstriker", "Grobbulus", "Heartseeker", "Herod", "Incendius", "Kirtonos", "Kromcrush", "Kurinnaxx", "Loatheb", "Mankrik", "Myzrael", "Netherwind", "Old Blanchy", "Pagle", "Rattlegore", "Remulos", "Skeram", "Smolderweb", "Stalagg", "Sul'thraze", "Sulfuras", "Thalnos", "Thunderfury", "Westfall", "Whitemane", "Windseeker", "Yojamba"];

        return view('dashboard.options')
            ->with('settings', $settings)
            ->with('server', $currentServer)
            ->with('naServerList', $naServerList)
            ->with('euServerList', $euServerList);
    }

    public function postOptions(Request $request, $serverID) {
        Setting::updateOrCreate(
            ['guildID' => $serverID],
            [
                'faction' => $request->faction,
                'server' => $request->wowServer,
                'region' => $request->region,
                'sheet' => $request->sheetID
            ]
        );
        return redirect()->route('dashboard', [$serverID]);
    }
}