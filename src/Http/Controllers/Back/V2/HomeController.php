<?php

namespace Ludows\Adminify\Http\Controllers\Back\V2;
use App\Adminify\Http\Controllers\Controller;

use Kris\LaravelFormBuilder\FormBuilder;

use Illuminate\Http\Request;
use Ludows\Adminify\Libs\DashboardService;


// use Ludows\Adminify\Interfacable\DashboardManager;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // private $interfacable;
    
    public function __construct()
    {
           // $this->interfacable = $interfacable;
        $this->middleware('auth');
        $this->middleware(['permission:read'], ['only' => ['show']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function showIndexPage(DashboardService $DashboardService)
    {

        $request = request();

        // $enabled_features = get_site_key('enables_features');

        // $interface = interfaces('home');

        // $blocks = $interface->getBlocks();

        // foreach ($blocks as $block) {
        //     # code...
        //     $a = new $block();
        //     if(empty( $enabled_features[ singular( $a->getPlural() ) ] ) ) {
        //         $interface->unregisterBlock( $block::getNamedBlock() );
        //     }
        //     if(!empty( $enabled_features[ singular( $a->getPlural() ) ] ) &&  $enabled_features[ singular( $a->getPlural() ) ] == false ) {
        //         $interface->unregisterBlock( $block::getNamedBlock() );
        //     }
        // }

        $DashboardService->load();

        $views = $this->getPossiblesViews('Dashboard');

        return $this->renderView( $views, [
            'model' => (object) [],
            'blocks' => $DashboardService->getBlocks()
        ]);
    }

    public function getForms(Request $request, FormBuilder $formbuilder) {

        $all = $request->all();

        $form = $formbuilder->create( $all['namespace'], $all['form-attributes']);

        return response()->json([
            'html' => form($form),
            'status' => 'OK'
        ]);
    }
    
    public function getContents(Request $request) {

        $all = $request->all();
        
        $view = view($all['view_name'], $all['view_vars'])->render();

        return response()->json([
            'html' => $view,
            'status' => 'OK'
        ]);
    }
}
