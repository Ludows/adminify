<?php

namespace Ludows\Adminify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminBreadcrumb
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
        // dd(app());
        $routeName = request()->route()->getName();



        \Breadcrumbs::for($routeName, function ($trail) {

            $request = request();
            $requestedNameRoute = $request->route()->getName();
            $routeSpl = explode('.', $requestedNameRoute);

            $trail->push( __('home.dashboard') , route('home.dashboard'));
            if(Str::contains($requestedNameRoute, 'index')) {
                $trail->push( __($routeSpl['0'].'.index') , route($routeSpl['0'].'.index'));
            }
            if(Str::contains($requestedNameRoute, 'create') ) {
                $trail->push( __($requestedNameRoute) , route($requestedNameRoute));
            }

            if(Str::contains($requestedNameRoute, 'edit')) {

                $trail->push( __($routeSpl['0'].'.index') , route($routeSpl['0'].'.index'));

                $singular = Str::singular($routeSpl['0']);
                // we find the model mapped by the crud mode
                $model = \Route::current()->parameter($singular);
                $trail->push( __($requestedNameRoute) , route($requestedNameRoute, [$singular => $model->id]));
            }



        });
        return $next($request);
    }
}
