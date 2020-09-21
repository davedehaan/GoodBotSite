<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Item;
use App\Enchant;
use App\Raid;
use App\Signup;
use App\Character;
use App\ReserveItem;
use App\RaidReserve;

class APIController extends Controller
{
    public function nick() {
        $params = $this->checkRequired(['guildID', 'memberID']);
        if (!empty($params['error'])) {
            return $params;
        }
        $userInfo = $this->botRequest('/guilds/' . $params['guildID'] . '/members/' . $params['memberID']);

        $nick = null;
        if (property_exists($userInfo, 'user')) {
            $nick = property_exists($userInfo, 'nick') && !empty($userInfo->nick) ? $userInfo->nick : $userInfo->user->username;
        }
        return ['nick' => $nick];
    }

    public function reserve() {
        $params = $this->checkRequired(['signupID', 'reserveItemID']);
        if (!empty($params['error'])) {
            return $params;
        }
        $signup = Signup::findOrFail($params['signupID']);
        $reserveItem = ReserveItem::findOrFail($params['reserveItemID']);
        $raid = Raid::findOrFail($signup->raidID);

        if ($raid->raid != $reserveItem->raid) {
            return ['error' => 'This is not a valid item for the specified raid.'];
        }

        $params['raidID'] = $signup->raidID;
        $reserve = RaidReserve::updateOrCreate([
            'signupID' => $params['signupID'],
            'raidID' => $params['raidID']
        ],
        [
            'reserveItemID' => $params['reserveItemID']
        ]);

        return $reserve;
    }

    public function reserveItems() {
        $params = $this->checkRequired(['raid']);
        if (!empty($params['error'])) {
            return $params;
        }
        return ReserveItem::where('raid', $params['raid'])->get();
    }

    public function checkRequired($required) {
        $returnArray = [];
        foreach ($required AS $parameter) {
            $returnArray[$parameter] = request()->get($parameter);
            if (empty($returnArray[$parameter])) {
                return ['error' => $parameter . ' is a required parameter.'];
            }
        }
        return $returnArray;
    }

    public function wclToken() {
        // cURL vars
        $tokenurl   = 'https://classic.warcraftlogs.com/oauth/token';
        $username   = env("WCL_USER");
        $password   = env("WCL_PASS");
        $post       = ['grant_type' => 'client_credentials'];
        $headers[]  = 'Accept: application/json';
        $headers[]  = 'Content-Type: application/json';

        // init curl
        $ch = curl_init($tokenurl);

        // curl settings
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        // Set headers, credentials, post data
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);      
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));

        $response = curl_exec($ch);
        $response = json_decode($response);
        // Save our token
        session(['wcl' => $response->access_token]);
    }

    public function gear($character, $server, $region) {
        if (empty(session()->get('wcl'))) {
            $this->wclToken();
        }

        // cURL vars
        $url        = 'https://classic.warcraftlogs.com/api/v2/client';
        $headers[]  = 'Accept: */*';
        $headers[]  = 'Content-Type: application/json';
        $headers[]  = 'Authorization: Bearer ' . session()->get('wcl');

        // init curl
        $ch = curl_init($url);

        // curl settings
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $query = '
            {
                characterData {
                    character(name: "' . $character . '", serverSlug: "' . $server . '", serverRegion: "' . $region . '") {
                        id
                        recentReports(limit: 1) {
                            startTime
                            masterData {
                                actors {
                                    id
                                    name
                                    subType
                                }
                            }

                            fights {
                                id
                                name
                                encounterID
                            }

                            events(startTime: -1, endTime: 9999999999, dataType: CombatantInfo, limit: 999999) {
                                data
                            }
                        }
                    }
                }
            }
        ';
        $query = json_encode(['query' => $query]);

        // Set headers, credentials, post data
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);      
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);

        $response = curl_exec($ch);
        $response = json_decode($response);
        
        // Drill down to the actual report
        if (empty($response->data->characterData->character)) {
            return ['error' => 'Player does not exist.'];
        }
        $lastReport = $response->data->characterData->character->recentReports[0];
        
        // Retrieve a list of all players who were present
        $players = $lastReport->masterData->actors;
        $playerLookup = [];
        foreach ($players AS $player) {
            $playerLookup[$player->id] = $player;
        }
        
        // We only want to know about the boss fights
        $fights = $lastReport->fights;
        $bossFights = [];
        foreach ($fights AS $key => $fight) {
            if (!empty($fight->encounterID)) {
                $bossFights[$fight->id] = $fight;
            }
        }

        // Get all combatant info about all characters within the raid
        $characterInfo = $lastReport->events->data;
        $gearCache = [];
        $itemIDs = [];
        $enchantIDs = [];
        foreach ($characterInfo AS $char) {
            // We only care about boss fights
            if (empty($bossFights[$char->fight])) {
                continue;
            }
            
            // Retrieve our player information
            $player = $playerLookup[$char->sourceID];
            if (empty($gearCache[$player->name])) {
                $gearCache[$player->name] = [];
            }

            // Create our $gearCache  for easier display
            $gearCache[$player->name][] = ['fight' => $bossFights[$char->fight], 'gear' => $char->gear];
            
            // Make an array of our item IDs for lookup
            foreach ($char->gear AS $item) {
                $itemIDs[] = $item->id;
                if (!empty($item->permanentEnchant)) {
                    $enchantIDs[] = $item->permanentEnchant;
                }
            }
        }

        $gearSlots = [
            'Head', // 0
            'Neck', // 1
            'Shoulders', //2
            'Shirt', // 3
            'Chest', // 4
            'Belt', // 5
            'Legs', // 6
            'Boots', // 7
            'Bracers', // 8
            'Gloves', // 9
            'Rings', // 10
            'Rings', // 11
            'Trinkets', // 12
            'Trinkets', // 13
            'Cloak', // 14
            'Main Hand', // 15
            'Off Hand', // 16
            'Ranged', // 17
            'Tabard', // 18
          ];

        $items = Item::whereIn('id', $itemIDs)->get();
        $itemLookup = [];
        foreach($items AS $item) {
            $itemLookup[$item->id] = $item->name;
        }

        $enchants = Enchant::whereIn('id', $enchantIDs)->get();
        $enchantLookup = [];
        foreach($enchants AS $enchant) {
            $enchantLookup[$enchant->id] = $enchant->enchant;
        }

        $playerGear = [];
        foreach ($gearCache AS &$playerGear) {
            foreach ($playerGear AS &$bossFight) {
                foreach ($bossFight['gear'] AS $key => &$playerGear) {
                    $playerGear->itemName = $itemLookup[$playerGear->id];
                    if (property_exists($playerGear, 'permanentEnchant')) {
                        $playerGear->enchantName = $enchantLookup[$playerGear->permanentEnchant];
                    }
                    $playerGear->slot = $gearSlots[$key];
                }
            }    
        }

        $return = [
            'raidTime' => date('Y-m-d H:i:s', $lastReport->startTime/1000),
            'data' => $gearCache[$character]
        ];

        //TODO: CACHE GearCache
        return $return;
    }

}