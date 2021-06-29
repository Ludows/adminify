<?php

namespace Ludows\Adminify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DisplayFullmode
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

        $fullmode = false;
        $v = view();

        $listFullModePages = [
            'pages.create',
            'pages.update',
            'posts.create',
            'posts.update',
        ];

        $routeName = $request->route()->getName();

        if( array_search($routeName, $listFullModePages) != false ) {
            $fullmode = true;
        }

        $v->share('fullmode', $fullmode);

        return $next($request);
    }
}
