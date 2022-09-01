<?php

namespace App\Http\Middleware;

use Closure;

use App\User;

use Auth;
class CheckRole
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
        if(Auth::user()->agent == 0 )
        {

            return redirect()->route('homepage');
        }else{

            return $next($request);
        }
    }
}
