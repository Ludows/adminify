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
            'pages.edit',
            'pages.update',
            'posts.create',
            'posts.update',
            'posts.edit',
        ];

        $routeName = $request->route()->getName();

        if( in_array($routeName, $listFullModePages) ) {
            $fullmode = true;
        }

        //dd($fullmode, $listFullModePages, $routeName);

        $v->share('fullmode', $fullmode);

        return $next($request);
    }
}
