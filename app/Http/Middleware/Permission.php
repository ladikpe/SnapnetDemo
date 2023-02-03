<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Permission
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
        $userRole = Auth::user()->roles->pluck('name');
        if(!$collection->contains('Admin Role'))
        {
            return redirect('/home');
        }
        return $next($request);
    }
}
