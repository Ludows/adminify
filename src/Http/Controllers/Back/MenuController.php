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
        public function showIndexPage(Request $request, FormBuilder $formBuilder)
        {
            $table = $this->table(MenuTable::class);


            return $this->renderView('Index', [
                'model' => (object) [],
                'table' => $table->toArray()
            ]);
        }

        /**
            * Show the form for creating a new resource.
            *
            * @return Response
            */
        public function showCreatePage(Request $request, FormBuilder $formBuilder, MenuBuilder $menuBuilder)
        {
            

            return $this->renderView('Create', [
                'model' => (object) [],
                'menubuilder' => $menuBuilder->toArray()
            ]);

        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function handleStore(CreateMenuRequest $request, FormBuilder $formBuilder)
        {
            // dd($request);
            $form = $this->makeForm(CreateMenu::class);
            $menu = $this->menuRepository->addModel(new Menu())->create($form);

            return $this->toJson([
                'message' => __('admin.typed_data.success'),
                'entity' => $menu,
                'route' => 'admin.menus.index'
            ]);
        }

        /**
            * Display the specified resource.
            *
            * @param  int  $id
            * @return Response
            */
        public function showPage($id)
        {
            //
        }

        /**
            * Show the form for editing the specified resource.
            *
            * @param  int  $id
            * @return Response
            */
        public function showEditPage(Menu $menu, MenuBuilder $menuBuilder)
        {

            $menu->checkForTraduction();
            // $menu->flashForMissing();

            $menuBuilder->setModel($menu);
            // dd($menuBuilder);


            return $this->renderView('Edit', [
                'model' => $menu,
                'menubuilder' => $menuBuilder->toArray()
            ]);
        }

        public function checkEntity(Request $request) {
            $config = config('site-settings');
            $shareds = inertia()->getShared();
            $type = $request->type;
            $id = $request->id;
            $ret = (object) [];
            $model = $config['menu-builder']['models'][$type];

            $check = $model::find($id);

            if($check != null) {
                $ret = $check;
            }

            return $this->toJson([
                'item' => $check,
                'multilang' => $shareds['useMultilang'],
                'type' => $type
            ]);
        }


        public function setItemsToMenu(Request $request, $type) {

            // $type = $request->type;
            // $v = view();
            $model = ucfirst($type);
            $m_str = adminify_get_class($model, ['app:models', 'app:adminify:models'], false);
            if(empty($m_str)) {
                abort(404);
            }
            $m = new $m_str;
            // $enabled_features = get_site_key('enables_features');

            $three = [];
            // $html = [];

            if($type == 'custom') {
                $three[] = (object) [
                    'title' => $request->input('title'),
                    'url' => $request->input('url'),
                    'slug' => Str::slug( $request->input('title'), '-' ),
                    'open_new_tab' => $request->input('open_new_tab') ? true : false,
                    'overwrite_title' => '',
                    'childs' => []
                ];
            }
            else {
                $items = $request->input('items');

                if(is_string($items)) {
                    $m = $m->find($items);
                    $m = $m->setAttribute('children', []);

                    $three[] = $m;
                }

                if(is_array($items)) {
                    foreach ($items as $item) {
                        # code...
                        $m = $m->find($item);
                        $m = $m->setAttribute('children', []);

                        $three[] = $m;
                    }
                }
            }

            // foreach ($three as $b) {
            //     # code...
            //     $html[] = $v->make('adminify::layouts.admin.menubuilder.menu-item', ['mediaMode' => isset($enabled_features['media']) && $enabled_features['media'], 'item' => $b, 'type' => $type, 'new' => true, 'isCustom' => $type == 'custom'])->render();
            // }

            return $this->toJson([
                'items' => $three,
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

            $m = $m->where('model_id', $id)->get()->first();

            $m = $m->delete();


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
        public function handleUpdate(MenuBuilder $menuBuilder,Menu $menu,  Request $request, FormBuilder $formBuilder)
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
        public function handleDestroy(MenuBuilder $menuBuilder,Menu $menu,  Request $request, FormBuilder $formBuilder)
        {
            //

            $this->menuRepository->addModel($menu)->delete($menu);

            return $this->sendResponse($menu, 'menus.index', 'admin.typed_data.deleted');

        }
}
