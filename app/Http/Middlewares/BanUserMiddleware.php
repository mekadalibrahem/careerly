<?php

namespace App\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BanUserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user= Auth::user();
        if($user->ban_at != null){
            abort(403,"this user is baned for this request");
        }
        return $next($request);
    }
}
