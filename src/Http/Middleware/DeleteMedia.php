<?php

namespace Ludows\Adminify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DeleteMedia
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
        $routeName = $request->route()->getName();

        if($routeName == 'medias.delete') {
            $m = \Route::current()->parameter('media');
            $request->items = [$m->src];
        }
        return $next($request);
    }
}
