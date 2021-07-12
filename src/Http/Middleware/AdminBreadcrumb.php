<?php

namespace Ludows\Adminify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

class AdminBreadcrumb
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function hasRoute($name) {
        return Route::has($name);
    }
    public function handle(Request $request, Closure $next)
    {
        // dd(app());
        $routeName = request()->route()->getName();



        \Breadcrumbs::for($routeName, function ($trail) {

            $request = request();
            $requestedNameRoute = $request->route()->getName();
            $routeSpl = explode('.', $requestedNameRoute);

            $trail->push( __('home.dashboard') , route('home.dashboard'));
            if(Str::contains($requestedNameRoute, 'index') && $this->hasRoute($routeSpl['0'].'.index')) {
                $trail->push( __($routeSpl['0'].'.index') , route($routeSpl['0'].'.index'));
            }
            if(Str::contains($requestedNameRoute, 'create') && $this->hasRoute($routeSpl['0'].'.create')) {
                $trail->push( __($requestedNameRoute) , route($requestedNameRoute));
            }

            if(Str::contains($requestedNameRoute, 'edit') && $this->hasRoute($routeSpl['0'].'.edit')) {

                if($this->hasRoute($routeSpl['0'].'.index')) {
                    $trail->push( __($routeSpl['0'].'.index') , route($routeSpl['0'].'.index'));
                }

                $singular = Str::singular($routeSpl['0']);
                // we find the model mapped by the crud mode
                $model = \Route::current()->parameter($singular);
                if($model != null) {
                    $trail->push( __($requestedNameRoute) , route($requestedNameRoute, [$singular => $model->id]));
                }
            }



        });
        return $next($request);
    }
}
