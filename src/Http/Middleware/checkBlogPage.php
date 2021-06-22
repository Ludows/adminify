<?php

namespace Ludows\Adminify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class checkBlogPage
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
        $blogpage = setting('blogpage');
        if($request->slug instanceof \App\Models\Page && (int) $blogpage != 0) {
            if($request->slug->id === (int) $blogpage) {
               $posts = new \App\Models\Post();
               $request->posts = $posts->all();
            }
        }

        return $next($request);
    }
}
