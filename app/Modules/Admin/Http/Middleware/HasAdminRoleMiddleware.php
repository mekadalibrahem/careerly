<?php

namespace App\Modules\Admin\Http\Middleware;

use App\Modules\Admin\Services\AdminAuthServices;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HasAdminRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!AdminAuthServices::AuthAdminRole()) {
            return response()->json(['error' => "forbidden"], 403);
        }

        return $next($request);
    }
}
