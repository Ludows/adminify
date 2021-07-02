<?php

namespace Ludows\Adminify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ShareCurrentUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $user = auth()->user();

        view()->share('user', $user);

        return $next($request);
    }
}
