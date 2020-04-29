<?php

namespace App\Http\Middleware;

use App\ApiKey;
use Closure;

class Api
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
        $key = $request->input('key');
        $id = $request->input('id');
        
        $access = ApiKey::where('key', $key)
            ->where('memberID', $id)->first();
        
        if (empty($access)) {
            abort(403, 'Unauthorized');
        }

        $request->attributes->add(['access' => $access]);

        return $next($request);
    }
}
