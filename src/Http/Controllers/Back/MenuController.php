<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Adminify\Http\Requests\CreateMenuRequest;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use Ludows\Adminify\Forms\CreateMenu;

use App\Adminify\Models\Menu;
use Ludows\Adminify\Libs\MenuBuilder;
use Illuminate\Support\Str;

use App\Adminify\Repositories\MenuRepository;
use App\Adminify\Http\Controllers\Controller;

use Ludows\Adminify\Traits\TableManagerable;
use App\Adminify\Tables\MenuTable;

class MenuController extends Controller
{
    use FormBuilderTrait;
    use TableManagerable;
    private $menuRepository;

    public function __construct(MenuRepository $menuRepository) {
        $this->menuRepository = $menuRepository;

        $this->middleware(['permission:read|create_menus'], ['only' => ['show','create']]);
        $this->middleware(['permission:read|edit_menus'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:read|delete_menus'], ['only' => ['destroy']]);
    }
    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        public function index(Request $request, FormBuilder $formBuilder)
        {
            $table = $this->table(MenuTable::class);

            return view("adminify::layouts.admin.pages.index", ["table" => $table]);
        }

        /**
            * Show the form for creating a new resource.
            *
            * @return Response
            */
        public function create(Request $request, FormBuilder $formBuilder, MenuBuilder $menuBuilder)
        {


            return view("adminify::layouts.admin.pages.create", ['menuBuilder' => $menuBuilder]);
        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function store(CreateMenuRequest $request, FormBuilder $formBuilder)
        {
            // dd($request);
            $form = $this->form(CreateMenu::class);
            $menu = $this->menuRepository->addModel(new Menu())->create($form);
            return $this->sendResponse($menu, 'menus.index', 'admin.typed_data.success');  
        }

        /**
            * Display the specified resource.
            *
            * @param  int  $id
            * @return Response
            */
        public function show($id)
        {
            //
        }

        /**
            * Show the form for editing the specified resource.
            *
            * @param  int  $id
            * @return Response
            */
        public function edit(Menu $menu, MenuBuilder $menuBuilder)
        {

            $menu->checkForTraduction();
            // $menu->flashForMissing();

            $menuBuilder->setModel($menu);
            // dd($menuBuilder);

            return view("adminify::layouts.admin.pages.edit", ['menuBuilder' => $menuBuilder]);
        }

        public function checkEntity(Request $request) {
            $config = config('site-settings');
            $type = $request->type;
            $id = $request->id;
            $ret = (object) [];
            $model = $config['menu-builder']['models'][$type];

            $check = $model::find($id);

            if($check != null) {
                $ret = $check;
            }

            return response()->json([
                'item' => $check,
                'multilang' => $request->useMultilang,
                'type' => $type
            ]);
        }


        public function setItemsToMenu(MenuBuilder $menuBuilder, Request $request) {

            $config = get_site_key('menu-builder');
            $type = $request->type;
            $v = view();

            $model = $config['models'][$type];
            $m_str = get_site_key($model);
            $m = new $m_str;
            $enabled_features = get_site_key('enables_features');

            $three = [];
            $html = [];

            if($type == 'custom') {
                $three[] = (object) [
                    'title' => $request->input('title'),
                    'url' => $request->input('url'),
                    'slug' => Str::slug( $request->input('title'), '-' ),
                    'open_new_tab' => $request->input('open_new_tab') ? true : false,
                    'overwrite_title' => ''
                ];
            }
            else {
                $items = $request->input('items');

                if(is_string($items)) {
                    $three[] = $m->find($items);
                }

                if(is_array($items)) {
                    foreach ($items as $item) {
                        # code...
                        $three[] = $m->find($item);
                    }
                }
            }

            foreach ($three as $b) {
                # code...
                $html[] = $v->make('adminify::layouts.admin.menubuilder.menu-item', ['mediaMode' => isset($enabled_features['media']) && $enabled_features['media'], 'item' => $b, 'type' => $type, 'new' => true, 'isCustom' => $type == 'custom'])->render();
            }
            

            return response()->json([
                'html' => $html,
                'items' => $three,
                'multilang' => $request->useMultilang,
                'type' => $type
            ]);

        }

        public function removeItemsToMenu(MenuBuilder $menuBuilder, Request $request) {

            $config = get_site_key('menu-builder');
            $id = $request->id;
            $v = view();

            $m = new \App\Adminify\Models\MenuItem();
            $three = [];
            $html = [];

            $m = $m->find($id)->delete();
            

            return response()->json([
                'status' => 'ok',
                'model' => $m,
                'message' => __('admin.typed_data.deleted'),
            ]);

        }

        

        /**
            * Update the specified resource in storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function update(MenuBuilder $menuBuilder,Menu $menu,  Request $request, FormBuilder $formBuilder)
        {
            $fields = $request->all();
            $menuThree = json_decode($fields['menuthree'], true);
            $menu = $this->menuRepository->addModel($menu)->update($menuThree, $menu);

            return $this->sendResponse($menu, 'menus.index', 'admin.typed_data.updated');  
        }

        /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function destroy(MenuBuilder $menuBuilder,Menu $menu,  Request $request, FormBuilder $formBuilder)
        {
            //

            $this->menuRepository->addModel($menu)->delete($menu);

            return $this->sendResponse($menu, 'menus.index', 'admin.typed_data.deleted');  

        }
}
