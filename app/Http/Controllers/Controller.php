<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    function botRequest($endpoint, $post = []) {
        $ch = curl_init(env('BOT_API_URL') . $endpoint);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $headers[] = 'Accept: application/json';
        $headers[] = 'Authorization: Bot ' . env('BOT_TOKEN');
      
        if (!empty($post)) {
            print_r($post);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        }        
  
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);      
        $response = curl_exec($ch);
        return json_decode($response);
    }

}
