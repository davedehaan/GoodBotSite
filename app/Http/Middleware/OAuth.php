<?php

namespace App\Http\Middleware;

use Closure;

class OAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        $authorizeURL   = 'https://discord.com/api/oauth2/authorize';
        $tokenURL       = 'https://discord.com/api/oauth2/token';
        $apiURLBase     = 'https://discord.com/api/users/@me';

        if ($request->query('code')) {
            session(['code' => $request->query('code')]);
            $token = $this->apiRequest($tokenURL, [
                "grant_type" => "authorization_code",
                'client_id' => env('OAUTH2_CLIENT_ID'),
                'client_secret' => env('OAUTH2_CLIENT_SECRET'),
                'redirect_uri' => env('OAUTH2_REDIRECT_URL'),
                'code' => session()->get('code')
            ]);
            session(['token' => $token->access_token]);
            $user = $this->apiRequest($apiURLBase);
            session(['user' => $user]);
            $guilds = $this->apiRequest($apiURLBase . '/guilds');
            usort($guilds, function($a, $b) { return $a->name <=> $b->name; });
            session(['guilds' => $guilds]);
            $state = $request->query('state') ? $request->query('state') : '/';
            $state = str_replace('%2F', '/', $state);
            return redirect($state);
        }

        if (!session()->get('user')) {
            $params = [
                'client_id' => env('OAUTH2_CLIENT_ID'),
                'redirect_uri' => env('OAUTH2_REDIRECT_URL'),
                'response_type' => 'code',
                'scope' => 'identify guilds',
                'state' => $request->path()
              ];
            
              $authorizeURL . '?' . http_build_query($params);
              return redirect($authorizeURL . '?' . http_build_query($params));
        }
        return $next($request);
    }

    function apiRequest($url, $post = FALSE, $headers = []) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
            
        if ($post) {
          curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        }
      
        $headers[] = 'Accept: application/json';
        if (session()->get('token')) {
          $headers[] = 'Authorization: Bearer ' . session()->get('token');
        }
      
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);      
        $response = curl_exec($ch);
        return json_decode($response);
      }
      
}
