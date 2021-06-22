<?php

namespace Ludows\Adminify\Http\Controllers\Back;
use Ludows\Adminify\Http\Controllers\Controller;


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


        $blocks = [];
        if(count($config['blocks']) > 0) {
            foreach ($config['blocks'] as $blockName => $arr) {
                # code...
                if($user->hasRole($arr['showIf'])) {
                    $m = $arr['class']::orderBy('id', 'desc')->take($config['limit'])->get();

                    $a = [
                        'data' => $m,
                        'type' => $blockName,
                        'column' => $arr['columnShow'],
                        'plural' => isset($arr['plural']) ? $arr['plural'] : str_plural($blockName)
                    ];

                    if(\Route::has(isset($arr['plural']) ? $arr['plural'].'.create' : str_plural($blockName).'.create')) {
                        $a['createLink'] = route( isset($arr['plural']) ? $arr['plural'].'.create' : str_plural($blockName).'.create');
                    }

                    $v = view()->make($arr['template'], $a);
                    $blocks[$blockName] = $v->render();
                }
            }
        }

        //dd($user, $config, $blocks);


        return view('layouts.admin.pages.dashboard', ['blocks' => $blocks]);
    }
}
