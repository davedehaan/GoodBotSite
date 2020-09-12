<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function botRequest($endpoint, $post = [], $patch = false) {
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
}
