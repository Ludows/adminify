<?php

namespace Ludows\Adminify\Http\Controllers\Back;
use Ludows\Adminify\Http\Controllers\Controller;
use Illuminate\Support\Str;

use Ludows\Adminify\Interfacable\DashboardManager;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $interfacable;
    
    public $cards = [
        'register.pages',
        // 'register.posts',
        // 'register.medias',
        // 'register.categories',
        // 'register.traductions',
        // 'register.comments'
    ];

    public function __construct(DashboardManager $interfacable)
    {
        $this->interfacable = $interfacable;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        $user = user();
        $config = get_site_key('dashboard');
        $request = request();

        
        // $this->interfacable->registerBlock('')


        foreach ($this->cards as $card) {
            # code...
        }
        // if(count($config['blocks']) > 0) {
        //     foreach ($config['blocks'] as $blockName => $arr) {
        //         # code...
        //         if($user->hasRole($arr['showIf'])) {
        //             $m_str = get_site_key($arr['class']);
        //             $m = new $m_str();

        //             if($request->useMultilang) {
        //                 $m = $m->orderBy('id', 'desc');
        //                 if(is_translatable_model($m)) {
        //                     $m = $m->lang($request->lang);
        //                 }
        //                 $m = $m->take($config['limit']);
        //                 $m = $m->get();
        //             }
        //             else {
        //                 $m = $m->orderBy('id', 'desc');
        //                 $m = $m->take($config['limit']);
        //                 $m = $m->get();
        //             }


        //             $a = [
        //                 'data' => $m,
        //                 'type' => $blockName,
        //                 'column' => $arr['columnShow'],
        //                 'plural' => isset($arr['plural']) ? $arr['plural'] : Str::plural($blockName)
        //             ];

        //             if(\Route::has(isset($arr['plural']) ? $arr['plural'].'.create' : Str::plural($blockName).'.create')) {
        //                 $a['createLink'] = route( isset($arr['plural']) ? $arr['plural'].'.create' : Str::plural($blockName).'.create');
        //             }

        //             $v = view()->make($arr['template'], $a);
        //             $blocks[$blockName] = $v->render();
        //         }
        //     }
        // }

        //dd($user, $config, $blocks);


        return view('adminify::layouts.admin.pages.dashboard', ['interfacable' => $this->interfacable]);
    }
}
