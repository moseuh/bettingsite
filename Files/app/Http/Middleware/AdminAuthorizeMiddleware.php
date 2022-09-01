<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\GeneralSettings;

class AdminAuthorizeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $access = null)
    {
        $adminAccess = json_decode(Auth::guard('admin')->user()->access);
        if(in_array($access, $adminAccess)){
            return $next($request);
        }
        abort(403);

    }
}
