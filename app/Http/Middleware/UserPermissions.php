<?php

namespace App\Http\Middleware;

use App\Exceptions\BaseHttpException;
use App\Exceptions\NoAccessHttpException;
use App\Exceptions\NotAuthHttpException;
use Closure;
use Illuminate\Http\Request;

class UserPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws BaseHttpException
     */
    public function handle(Request $request, Closure $next, string $perm)
    {
        $user = $request->user();
        if(!$user)
            throw new NotAuthHttpException();

        if(!$user->hasAccess($perm))
            throw new NoAccessHttpException();

        return $next($request);
    }
}
