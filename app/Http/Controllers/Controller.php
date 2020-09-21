<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    function botRequest($endpoint, $post = [], $patch = false) {
        $ch = curl_init(env('BOT_API_URL') . $endpoint);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bot ' . env('BOT_TOKEN');
      
        if ($patch) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        } else if (!empty($post)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        }        
  
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);      
        $response = curl_exec($ch);
        return json_decode($response);
    }

    public function sendMessage($serverID = 0, $channelID = 0, $message) {
        if ($serverID) {
            $channels = $this->botRequest('/guilds/' . $serverID . '/channels');
            foreach ($channels AS $channel) {
                if ($channel->type == 0) {
                    $channelID = $channel->id;
                    break;
                }
            }
        }
        $text = $this->botRequest('/channels/' . $channelID . '/messages', ['content' => $message]);
    }

    public function goodBotInstalled($serverID) {
        $channels = $this->botRequest('/guilds/' . $serverID . '/channels');
        if (!is_array($channels)) {
            abort(redirect('/dashboard/install/' . $serverID));
        }
    }

    public function getServer($serverID, $adminCheck = true) {
        
        // Retrieve guild information
        $servers = $this->botRequest('/guilds');
        usort($servers, function($a, $b) { return $a->name <=> $b->name; });
        session(['guilds' => $servers]);
        
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

        $user = session()->get('user');
        if ($adminCheck && $currentServer->permissions != 2147483647) {
            abort(403);
        }

        return $currentServer;
    }

}
