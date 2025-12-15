<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasRoleAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->isAdmin()) {
            return $next($request);
        }

        // kalau mau 403 juga boleh, tapi kita pakai 404 biar "sembunyi"
        abort(404);
    }
}
