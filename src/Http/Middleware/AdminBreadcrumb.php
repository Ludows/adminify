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

            $singular = Str::singular($routeSpl['0']);
            // we find the model mapped by the crud mode
            $model = \Route::current()->parameter($singular);

            $entity_name = __('admin.menuback.'.$routeSpl['0']); 

            $trail->push( __('admin.breadcrumb.root') , route('home.dashboard'));
            if(Str::contains($requestedNameRoute, 'index') && $this->hasRoute($routeSpl['0'].'.index')) {
                $trail->push(  __('admin.breadcrumb.index', ['entity' => $entity_name]) , route($routeSpl['0'].'.index'));
            }
            if(Str::contains($requestedNameRoute, 'create') && $this->hasRoute($routeSpl['0'].'.create')) {
                
                if($this->hasRoute($routeSpl['0'].'.index')) {
                    $trail->push( __('admin.breadcrumb.index', ['entity' => $entity_name]) , route($routeSpl['0'].'.index'));
                }

                $trail->push( __('admin.breadcrumb.create', ['entity' => $entity_name]) , route($requestedNameRoute));
            }

            if(Str::contains($requestedNameRoute, 'edit') && $this->hasRoute($routeSpl['0'].'.edit')) {

                if($this->hasRoute($routeSpl['0'].'.index')) {
                    $trail->push( __('admin.breadcrumb.index', ['entity' => $entity_name]) , route($routeSpl['0'].'.index'));
                }

                
                if($model != null && $model instanceof \Illuminate\Database\Eloquent\Model) {
                    $trail->push( __('admin.breadcrumb.edit', ['entity' => $entity_name]) , route($requestedNameRoute, [$singular => $model->id]));
                }
            }



        });
        return $next($request);
    }
}
