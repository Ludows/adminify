<?php

namespace Ludows\Adminify\Http\Controllers\Back;
use Ludows\Adminify\Http\Controllers\Controller;
use Illuminate\Support\Str;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        $user = auth()->user();
        $config = config('site-settings.dashboard');
        $request = request();


        $blocks = [];
        if(count($config['blocks']) > 0) {
            foreach ($config['blocks'] as $blockName => $arr) {
                # code...
                if($user->hasRole($arr['showIf'])) {
                    $m_str = get_site_key($arr['class']);
                    $m = new $m_str();

                    if($request->useMultilang) {
                        $m = $m->orderBy('id', 'desc');
                        if(is_translatable_model($m)) {
                            $m = $m->lang($request->lang);
                        }
                        $m = $m->take($config['limit']);
                        $m = $m->get();
                    }
                    else {
                        $m = $m->orderBy('id', 'desc');
                        $m = $m->take($config['limit']);
                        $m = $m->get();
                    }


                    $a = [
                        'data' => $m,
                        'type' => $blockName,
                        'column' => $arr['columnShow'],
                        'plural' => isset($arr['plural']) ? $arr['plural'] : Str::plural($blockName)
                    ];

                    if(\Route::has(isset($arr['plural']) ? $arr['plural'].'.create' : Str::plural($blockName).'.create')) {
                        $a['createLink'] = route( isset($arr['plural']) ? $arr['plural'].'.create' : Str::plural($blockName).'.create');
                    }

                    $v = view()->make($arr['template'], $a);
                    $blocks[$blockName] = $v->render();
                }
            }
        }

        //dd($user, $config, $blocks);


        return view('adminify::layouts.admin.pages.dashboard', ['blocks' => $blocks]);
    }
}
