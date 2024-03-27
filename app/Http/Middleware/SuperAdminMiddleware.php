<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\SuperAdminMiddleware as Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()->isSuperAdmin()) {
            abort(Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
