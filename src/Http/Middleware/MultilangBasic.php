<?php

namespace Ludows\Adminify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class MultilangBasic
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

        $config = config('site-settings');
        $getTextConfig = config('laravel-gettext.supported-locales');
        $routeName = $request->route()->getName();
        
        if($config['multilang']) {
            
            $currentLocale = \LaravelGettext::getLocale();
            $routeNameSpl = explode('.', $routeName);
            // these routes needs singular parameter
            $checkedKeys = [
                'update',
                'edit',
                'destroy'
            ];

            $request->isCrudPattern = false;
            $request->singleParam = null;
            $request->useMultilang = $config['multilang'];
            // dd($request->useMultilang);
            foreach ($checkedKeys as $checkedKey) {
                # code...
                if(in_array($checkedKey , $routeNameSpl )) {
                    $request->merge(["isCrudPattern"=> true ]);
                    $request->merge(["singleParam"=> Str::singular($routeNameSpl[0]) ]);
                    // $request->isCrudPattern = true;
                    // $request->singleParam = Str::singular($routeNameSpl[0]);
                    break;
                }
            }

            if(isset($request->lang) && $request->lang != $currentLocale) {
                //we update the value
                \LaravelGettext::setLocale($request->lang);
                $currentLocale = $request->lang;
            }

            // $request->lang = $currentLocale;
            $request->merge([
                "lang"=> $currentLocale,
                "langs" => $getTextConfig,
                "currentRouteName" => $routeName,
                "useMultilang" => $config['multilang']
            ]);

            view()->share('langs', $getTextConfig);
            view()->share('currentLang', $currentLocale);
            view()->share('currentRouteName', $routeName);
            view()->share('useMultilang', $config['multilang']);

            if(!isset($request->lang) && !in_array('store' , $routeNameSpl )) {
                $request->lang = $currentLocale;
                return redirect(route($routeName, ['lang' => $request->lang]));
            }
            else {
                return $next($request);
            }

        }
        else {

            $request->isCrudPattern = false;
            $request->singleParam = null;
            $request->useMultilang = $config['multilang'];

            $request->merge([
                "lang"=> 'fr',
                "langs" => $getTextConfig,
                "currentRouteName" => $routeName,
                "useMultilang" => $config['multilang']
            ]);

            return $next($request);
        }
    }
}
