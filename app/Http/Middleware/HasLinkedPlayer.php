<?php

namespace App\Http\Middleware;

use App\Exceptions\PlayerNotLinkedHttpException;
use Closure;
use Illuminate\Http\Request;

class HasLinkedPlayer
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(is_null($request->user()?->player_id))
            throw new PlayerNotLinkedHttpException();

        return $next($request);
    }
}
