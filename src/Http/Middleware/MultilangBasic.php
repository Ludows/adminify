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
        $v = view();

        $checkedKeys = [
            'update',
            'edit',
            'destroy'
        ];

        $currentLocale = \LaravelGettext::getLocale();
        $routeNameSpl = explode('.', $routeName);

        $base_parameters = [
            "isCrudPattern"=> false,
            "singleParam"=> Str::singular($routeNameSpl[0]),
            "useMultilang" => $config['multilang'],
            "lang"=> $currentLocale,
            "langs" => $getTextConfig,
            "currentRouteName" => $routeName,
        ];

        $v->share('langs', $getTextConfig);
        $v->share('currentLang', $currentLocale);
        $v->share('currentRouteName', $routeName);
        $v->share('useMultilang', $config['multilang']);

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

            if(isset($request->lang) && $request->lang != $currentLocale) {
                //we update the value
                \LaravelGettext::setLocale($request->lang);
                $currentLocale = $request->lang;
                merge_to_request('lang', $currentLocale);
            }

            if(!isset($request->lang) && !in_array('store' , $routeNameSpl )) {
                merge_to_request('lang', $currentLocale);
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
