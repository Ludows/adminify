<?php

namespace Ludows\Adminify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserPermissions
{
    function __construct(Request $request) {
        $this->needRedirect = false;
        $this->request = $request;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $user = $this->request->user();
        $userRole = $user->roles->first()->name;
        $name = $this->request->route()->getName();
        $config = config('check-permissions');

        $routesConfigByRole = $config['forceRedirect'][$userRole];

        if(isset($routesConfigByRole) && count($routesConfigByRole) > 0) {
            foreach ($routesConfigByRole as $routeConfigByRole) {
                # code...
                if($this->needRedirect == false) {
                    $this->checkRoute($routeConfigByRole);
                }
                else {
                    break;
                }
            }
        }
        // dd($routesConfigByRole);
        if($this->needRedirect) {
            return redirect(route($config['redirectTo']));
        }

        return $next($request);
    }
    public function checkRoute($namedRoute) {
        $name = $this->request->route()->getName();
        $spl_name = explode('.', $name);
        $isWildCardRoute = strpos($namedRoute, '.*') != false;
        // dd($namedRoute, $spl_name[0]);
        if($isWildCardRoute) {

            if(is_int(strpos($namedRoute, $spl_name[0]))) {
                $this->needRedirect = true;
            }
        }
        else {

            if($name === $namedRoute) {
                $this->needRedirect = true;
            }
        }


        // dd($namedRoute , $isWildCardRoute);
    }
}
