<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

}