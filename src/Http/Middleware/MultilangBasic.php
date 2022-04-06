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
        $route = $request->route();
        $routeName = $request->route()->getName();
        $prefix = $route->getPrefix();
        $v = view();

        $checkedKeys = [
            'update',
            'edit',
            'destroy'
        ];

        $currentLocale = App::currentLocale();
        $routeNameSpl = explode('.', $routeName);

        if(is_admin() && !empty($prefix)) {
            // dd('$prefix', $prefix);
            array_unshift($routeNameSpl , 'admin');
        }



        // making autoswitch back / front
        $singular = singular(is_admin() ? $routeNameSpl['1'] : 'slug');
        $model = \Route::current()->parameter($singular);

        $named = join('.',array_diff($routeNameSpl, ['index', 'edit', 'create']));
        // $bindedEditorKeys = array_keys($config['editor']['bind']);

        if(strpos($named, '.') != false) {
            $named = explode('.', $named);
            $named = $named[ count($named) - 1 ];
        }

        $base_parameters = [
            "siteConfig" => $config,
            "name" => $named,
            "isCrudPattern"=> false,
            "prefixUrl" => $prefix,
            "singleParam"=> count($routeNameSpl) > 2 ? Str::singular($routeNameSpl[ count($routeNameSpl) - 2 ])  : Str::singular($routeNameSpl[0]),
            "currentRouteSplitting" => $routeNameSpl,
            "routeParameters" => $request->route()->parameters(),
            "useMultilang" => (bool) $config['multilang'],
            "lang"=> $currentLocale,
            "currentLang" => $currentLocale,
            "langs" => $supported_locales,
            "currentRouteName" => $routeName,
            "isCreate" => strpos($routeName, '.create') != false ? true : false,
            "isEdit" => strpos($routeName, '.edit') != false ? true : false,
            "isUpdate" => strpos($routeName, '.update') != false ? true : false,
            "isDestroy" => strpos($routeName, '.destroy') != false ? true : false,
            "isIndex" => strpos($routeName, '.index') != false ? true : false,
            "model" => $model,
            "form" => null,
            "user" => user(),
            "adminify_autoload" => adminify_autoload(),
            // "loadEditor" => false,
            // 'bindedEditorKeys' => $bindedEditorKeys
        ];

        if(!is_admin() && !is_auth_routes()) {
            $posts = null;
            // si c'est la page de blog. Autoappend des posts.
            if(is_blogpage($model)) {
                $posts = new \Ludows\Adminify\Models\Post();
                $posts = $posts->dontCache()->all();
            }
            $topbarPref = get_user_preference('topbar');
            $topbarShow = false;

            // get the current theme
            $theme = theme();

            if(empty($theme)) {
                throw new \Exception("Theme must be set in administration", $theme);
            }

            //dd($topbarPref);
            if(!empty($topbarPref)) {
                $topbarShow = (bool)$topbarPref;
            }
            // add specifics globals vars
            $base_parameters['isHome'] = is_homepage($model);
            $base_parameters['isSingle'] = is_single($model);
            $base_parameters['isBlogPage'] = is_blogpage($model);
            $base_parameters['isPage'] = is_page($model);
            $base_parameters['isSearch'] = is_search($model);
            $base_parameters['posts'] = $posts;
            $base_parameters['topbarShow'] = $topbarShow;
            $base_parameters['theme'] = $theme;
            $base_parameters['isPreview'] = is_content_type_model($model);
        }



        // if(in_array(titled($base_parameters['singleParam']), $bindedEditorKeys) && !$base_parameters['isIndex']) {
        //     $base_parameters['loadEditor'] = true;
        //     merge_to_request('loadEditor', true);
        // }

        foreach ($base_parameters as $key => $value) {
            # code...
            $v->share($key, $value);
            add_to_request($key, $value);
        }

        foreach ($checkedKeys as $checkedKey) {
            # code...
            if(in_array($checkedKey , $routeNameSpl )) {
                merge_to_request('isCrudPattern', true);
                break;
            }
        }

        $v->share('request', $request);

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
