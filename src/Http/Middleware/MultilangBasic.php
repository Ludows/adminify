<?php

namespace Ludows\Adminify\Http\Middleware;

use Illuminate\Support\Facades\App;
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
        $supported_locales = $config['supported_locales'];
        $routeName = $request->route()->getName();
        $v = view();

        $checkedKeys = [
            'update',
            'edit',
            'destroy'
        ];

        $currentLocale = App::currentLocale();
        $routeNameSpl = explode('.', $routeName);

        $base_parameters = [
            "isCrudPattern"=> false,
            "singleParam"=> Str::singular($routeNameSpl[0]),
            "useMultilang" => (bool) $config['multilang'],
            "lang"=> $currentLocale,
            "langs" => $supported_locales,
            "currentRouteName" => $routeName,
        ];

        $v->share('name', join('.',array_diff($routeNameSpl, ['index', 'edit', 'create'])));
        $v->share('langs', $supported_locales);
        $v->share('currentLang', $currentLocale);
        $v->share('currentRouteName', $routeName);
        $v->share('useMultilang',  (bool) $config['multilang']);

        foreach ($base_parameters as $key => $value) {
            # code...
            add_to_request($key, $value);
        }

        foreach ($checkedKeys as $checkedKey) {
            # code...
            if(in_array($checkedKey , $routeNameSpl )) {
                merge_to_request('isCrudPattern', true);
                break;
            }
        }


        if($config['multilang']) {

            $langParameter = $request->get('lang');
            // dd($request->get('lang'), $currentLocale);
            if($langParameter && $langParameter != $currentLocale) {
                //we update the value
                $v->share('currentLang', $langParameter);
                App::setLocale($langParameter);
                $currentLocale = $langParameter;
                merge_to_request('lang', $currentLocale);
            }

            if(!isset($request->lang) && !in_array('store' , $routeNameSpl )) {
                merge_to_request('lang', $currentLocale);
                $v->share('currentLang', $currentLocale);
                return redirect(route($routeName, ['lang' => $request->lang]));
            }
            else {
                return $next($request);
            }

        }
        else {
            return $next($request);
        }
    }
}
