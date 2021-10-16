<?php

namespace App\Http\Middleware;

use App\Exceptions\NoAccessHttpException;
use App\Exceptions\NotAuthHttpException;
use Closure;
use Illuminate\Http\Request;

class RoleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $role
     * @return mixed
     * @throws NoAccessHttpException
     * @throws NotAuthHttpException
     */
    public function handle(Request $request, Closure $next, string $role): mixed
    {
        if($request->user() == null)
            throw new NotAuthHttpException();

        if(!$request->user()->checkRole($role))
            throw new NoAccessHttpException();

        return $next($request);
    }
}
