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

        $blogpage = setting('blogpage');
        $posts = null;
        // si c'est la page de blog. Autoappend des posts.
        if($request->slug instanceof \App\Adminify\Models\Page && (int) $blogpage != 0) {
            if($request->slug->id === (int) $blogpage) {
               $posts = new \Ludows\Adminify\Models\Post();
               $posts = $posts->all();
            }
        }

        $checkedKeys = [
            'update',
            'edit',
            'destroy'
        ];

        $currentLocale = App::currentLocale();
        $routeNameSpl = explode('.', $routeName);

        $singular = Str::singular($routeNameSpl['0']);
        $model = \Route::current()->parameter($singular);

        $named = join('.',array_diff($routeNameSpl, ['index', 'edit', 'create']));
        $bindedEditorKeys = array_keys($config['editor']['bind']);

        if(strpos($named, '.') != false) {
            $named = explode('.', $named);
            $named = $named[ count($named) - 1 ];
        }

        $base_parameters = [
            "siteConfig" => $config,
            "name" => $named,
            "isCrudPattern"=> false,
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
            "user" => user(),
            "posts" => $posts,
            "adminify_autoload" => adminify_autoload(),
            "loadEditor" => false,
            'bindedEditorKeys' => $bindedEditorKeys
        ];


        
        if(in_array(titled($base_parameters['singleParam']), $bindedEditorKeys) && !$base_parameters['isIndex']) {
            $base_parameters['loadEditor'] = true;
            merge_to_request('loadEditor', true);
        }

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

        $this->handleAssets();

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
    public function handleAssets() {

        $assetsConfig = config('assets');
        $keysAssets = array_keys($assetsConfig);
        $isAdmin = is_admin();
        $keyToBind = 'backend';

        if(!$isAdmin) {
            $keyToBind = 'frontend';
        }

        $keyCollections = array_keys($assetsConfig[$keyToBind]['collections']);

        // add asset
        add_asset($keyToBind, $keyCollections);
    }
}
