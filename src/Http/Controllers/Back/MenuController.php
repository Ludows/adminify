<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use Ludows\Adminify\Http\Requests\CreateMenuRequest;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use Ludows\Adminify\Forms\MenuSwitcher;
use Ludows\Adminify\Forms\MenuItemsThree;
use Ludows\Adminify\Forms\CreateMenu;
use Ludows\Adminify\Forms\DeleteCrud;

use Ludows\Adminify\Models\Menu;
use Ludows\Adminify\Libs\MenuBuilder;
use Illuminate\Support\Str;

use Ludows\Adminify\Repositories\MenuRepository;
use Ludows\Adminify\Http\Controllers\Controller;

use Ludows\Adminify\Dropdowns\Menu as MenuDropdownManager;


class MenuController extends Controller
{
    use FormBuilderTrait;
    private $menuRepository;

    public function __construct(MenuRepository $menuRepository) {
        $this->menuRepository = $menuRepository;
    }
    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        public function index(Request $request, FormBuilder $formBuilder)
        {
            $model = new Menu();
            $fillables = $model->getFillable();


            if($request->useMultilang) {
                $menus = Menu::lang($request->lang);
                // dd($categories);
                $menus = $menus->all();
            }
            else {
                $menus = Menu::all();
            }

            $a = new MenuDropdownManager($menus, []);

            if(isset($menus) && count($menus) > 0) {
                $menus[0]->flashForMissing();
            }

            return view("adminify::layouts.admin.pages.index", ["datas" => $menus, 'dropdownManager' => $a, 'thead' => $fillables]);
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
            $menu = $this->menuRepository->create($form, $request);
            if($request->ajax()) {
                return response()->json([
                    'menu' => $menu,
                    'status' => 'Le Menu a bien été crée !'
                ]);
            }
            else {
                flash('Le Menu a bien été crée !')->success();
                return redirect()->route('menus.index');
            }
            // $name = $request->input('name');

            //
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
            $menu->flashForMissing();

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

            $config = config('site-settings');
            $type = $request->type;
            $v = view();

            $model = $config['menu-builder']['models'][$type];

            $three = [];
            $html = [];

            if($type == 'custom') {
                $three[] = (object) [
                    'title' => $request->input('title'),
                    'url' => $request->input('url'),
                    'slug' => Str::slug( $request->input('title'), '-' ),
                    'open_new_tab' => $request->input('open_new_tab') ? true : false,
                ];
            }
            else {
                $items = $request->input('items');

                if(is_string($items)) {
                    $three[] = $model::find($items);
                }

                if(is_array($items)) {
                    foreach ($items as $item) {
                        # code...
                        $three[] = $model::find($item);
                    }
                }
            }

            foreach ($three as $b) {
                # code...
                $html[] = $v->make('adminify::layouts.admin.menubuilder.menu-item', ['item' => $b, 'type' => $type, 'new' => true, 'isCustom' => $type == 'custom'])->render();
            }
            

            return response()->json([
                'html' => $html,
                'items' => $three,
                'multilang' => $request->useMultilang,
                'type' => $type
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
            $menu = $this->menuRepository->update($menuThree, $menu);

            if($request->ajax()) {
                return response()->json([
                    'menu' => $menu,
                    'status' => 'Le Menu a bien été mis a jour !'
                ]);
            }
            else {
                flash('Le Menu a bien été mis a jour !')->success();
                return redirect()->route('menus.index')->with('status', 'Le Menu a bien été mis a jour !');
            }
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

            $this->menuRepository->delete($menu);

            flash('Le Menu a bien été supprimé !')->success();
            return redirect()->route('menus.index')->with('status', 'Le Menu a bien été supprimé !');

        }
}
