<?php

namespace Ludows\Adminify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Ludows\Adminify\Traits\SeoGenerator;
use Illuminate\Support\Str;

class BackendSeo
{
    use SeoGenerator;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $a = [];
        $routeName = $request->route()->getName();
        $isEdit =  Str::contains($routeName, 'edit');
        $isCreate =  Str::contains($routeName, 'create');
        $isIndex =  Str::contains($routeName, 'index');

        if($isEdit) {

        }
        if($isCreate) {

        }
        if($isIndex) {

        }

        $a['title'] = __('admin.seo.title'); // todo parameter for change page
        $a['description'] = __('admin.seo.description');
        $a['keywords'] = __('admin.seo.keywords');
        $a['robots'] = 'none';
        $a['type'] = 'page';

        $this->handleSeo($a);

        return $next($request);
    }
}
