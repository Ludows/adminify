<?php

namespace Ludows\Adminify\Http\Controllers\Back;
use Ludows\Adminify\Http\Controllers\Controller;

use Ludows\Adminify\Interfacable\DashboardManager;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $interfacable;
    
    public function __construct(DashboardManager $interfacable)
    {
        $this->interfacable = $interfacable;
        $this->middleware('auth');
        $this->middleware(['permission:read'], ['only' => ['show']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        $user = user();
        $blocks = get_site_key('dashboard');
        $request = request();

        foreach ($blocks as $block) {
            # code...
            $this->interfacable->registerBlock( $block::getNamedBlock(), $block );
        }

        return view('adminify::layouts.admin.pages.dashboard', ['interfacable' => $this->interfacable]);
    }
}
