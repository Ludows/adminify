<?php

namespace Ludows\Adminify\Libs;

use App\Adminify\Models\Menu;
use App\Adminify\Models\MenuItem;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Adminify\Http\Controllers\MenuController;
use App\Adminify\Forms\MenuSwitcher;
use App\Adminify\Forms\CreateMenu;
use App\Adminify\Forms\UpdateMenu;
use App\Adminify\Forms\SetItemsToMenu as SetItemsToMenuBaseMenuBuilder;
use App\Adminify\Forms\DeleteCrud;

class MenuBuilder
{
    use FormBuilderTrait;
    public function __construct() {
        $this->request = request();
        $this->config = config('site-settings');
        $this->app = app();
        $this->forms = [];
        $this->model = null;
    }
    public function setModel($model) {
        $this->model = $model;
    }
    public function getModel() {
        return $this->model;
    }
    public function getForms() {
        return $this->forms;
    }
    public function getForm($formKey = '') {
        return $this->forms[$formKey];
    }
    public function setForm($formKey, $formClass) {
        $this->forms[$formKey] = $formClass;
        return $this;
    }
    public function getRequest() {
        return $this->request;
    }
    public function getConfig() {
        return $this->config;
    }
    public function getTemplate() {
        return 'adminify::layouts.admin.menubuilder.default';
    }
    public function getDefaultsVars() {
        $array = [];
        $config = $this->getConfig();
        $request = $this->getRequest();
        $multilang = $request->useMultilang;
        $lang = $request->lang;

        $array['config'] = $config;
        $array['request'] = $request;
        $array['multilang'] = $multilang;
        $array['lang'] = $lang;

        return $array;
    }
    public function isNamedRoute($routeName = '') {
        $routeCheck =$this->request->route()->getName();
        // dd(strpos($routeCheck, $routeName));
        return strpos($routeCheck, $routeName) != false ? true : false;
    }
    private function loadRequiredForms() {
        $model = $this->getModel();
        $menuSwitcher = $this->form(MenuSwitcher::class, [
            'method' => 'GET',
            'url' => null
        ]);
        $this->forms['formMenuSwitcher'] = $menuSwitcher;

        $formSetItemsToMenu = $this->form(SetItemsToMenuBaseMenuBuilder::class, [
            'method' => 'POST',
            'url' => null
        ]);

        $this->forms['formSetItemsToMenu'] = $formSetItemsToMenu;

        if($model != null && $this->isNamedRoute('edit')) {

            $formDeleteMenu = $this->form(DeleteCrud::class, [
                'method' => 'POST',
                'url' => route('menus.destroy', ['menu' => $model->id])
            ]);

            $formDeleteMenu->remove('submit');

            $this->forms['formDeleteMenu'] = $formDeleteMenu;
        }

        if($this->isNamedRoute('create')) {
            $formCreateMenu = $this->form(CreateMenu::class, [
                'method' => 'POST',
                'url' => route('menus.store')
            ]);
        }
        else {

            $formCreateMenu = $this->form(UpdateMenu::class, [
                'method' => 'PUT',
                'url' => route('menus.update', ['menu' => $model->id]),
                'model' => $model
            ]);

            $formCreateMenu->addBefore('submit', 'suppress_menu', 'button', ['label' => __('admin.form.delete') , 'attr' => [ 'data-menu-id' => $model->id, 'id' => 'deleteMenuBtn', 'class' => 'btn btn-danger']]);
        }
        $this->forms['formCreateMenu'] = $formCreateMenu;

        return $this;
    }
    private function pluckable($array = [], $fields = []) {
        $returnableArray = [];

        foreach ($array as $model) {
            # code...
            foreach ($fields as $field => $key) {
                # code...
                $returnableArray[$model->{$field}] = $model->{$key};
            }
        }

        return $returnableArray;
    }
    public function getMenuSwitcherVars() {
        $menus = [];
        $defaultsVars = $this->getDefaultsVars();
        $r = $this->getRequest();
        if($defaultsVars['multilang']) {
            $menus = $r->menu != null ? Menu::where('id', '!=' , $r->menu->id)->lang($defaultsVars['lang'])->get()->all() : Menu::lang($defaultsVars['lang'])->get()->all();
        }
        else {
            $menus = $r->menu != null ? Menu::where('id', '!=' , $r->menu->id)->get()->all() : Menu::all()->all();
        }
        return $menus;
    }
    public function getMenuThreeVars() {
        $array = [];
        $defaultsVars = $this->getDefaultsVars();
        return $array;
    }
    public function getSidebarVars() {
        $array = [];
        $defaultsVars = $this->getDefaultsVars();
        // dd($config['menu-builder']['models']);
        $models = $defaultsVars['config']['menu-builder']['models'];
        if(count($models) > 0) {
            foreach ($models as $model => $key) {
                # code...
                $m_str = adminify_get_class($key, ['app:models', 'app:adminify:models'], false);
                $class_call = new $m_str;
                if(!array_key_exists($model, $defaultsVars['config']['menu-builder']['showAlways'])) {

                    if($defaultsVars['multilang']) {
                        $check_all_from_called_class = $class_call::lang($defaultsVars['lang'])->get()->all();
                    }
                    else {
                        $check_all_from_called_class = $class_call->get()->all();
                    }

                    if(count($check_all_from_called_class) > 0) {
                        $array[$model] = $check_all_from_called_class;
                    }
                }
                else {
                    $array[$model] = $defaultsVars['config']['menu-builder']['showAlways'][$model];
                }
            }
        }
        return $array;
    }
    public function runHydratorForms($vars = []) {
        $model = $this->getModel();
        if(count($vars['menuSwitcherVars']) > 0 && $model != null) {
            $pluckable_menus = $this->pluckable($vars['menuSwitcherVars'], [
                'id' => 'title'
            ]);
            // dd($this->forms['formMenuSwitcher']);
            $this->forms['formMenuSwitcher']->modify('menus', 'select', [
                'choices' => $pluckable_menus
            ]);
        }


        if(count($vars['sidebarVars']) > 0 && $model != null) {
            foreach ($vars['sidebarVars'] as $collectionName => $key) {
                # code...

                $tplDynamicForm = null;
                $tplDynamicForm = $this->form(SetItemsToMenuBaseMenuBuilder::class, [
                    'method' => 'POST',
                    'url' => route('menus.setItemsToMenu', ['id' => $model->id, 'type' => $collectionName])
                ]);

                if($collectionName != 'custom') {
                    //var_dump($collectionName);
                    $pluckable_items = $this->pluckable($key, [
                        'id' => 'title'
                    ]);
                    // dd($this->forms['formMenuSwitcher']);
                    $tplDynamicForm->modify('items', 'select2', [
                        'choices' => $pluckable_items,
                        'empty_value' => __('admin.select.'.$collectionName)
                    ]);
                }
                else {
                    $tplDynamicForm->remove('items');
                    foreach ($key as $fieldType => $keyable) {
                        # code...

                        $tplDynamicForm->addBefore('submit', $fieldType, $keyable['type'], $keyable['options']);
                    }
                }

                $this->setForm('form'.$collectionName, $tplDynamicForm);
            }
        }
    }
    public function render() {

        $this->loadRequiredForms();

        $model = $this->getModel();
        $view = $this->getTemplate();
        $sidebarVars = $this->getSidebarVars();
        $menuSwitcherVars = $this->getMenuSwitcherVars();
        $menuThreeVars = $this->getMenuSwitcherVars();
        $enabled_features = get_site_key('enables_features');


        $this->runHydratorForms([
            'sidebarVars' => $sidebarVars,
            'menuSwitcherVars' => $menuSwitcherVars,
            'menuThreeVars' => $menuThreeVars,
        ]);



        return view($view, ['isCreatedNamedRoute' => $this->isNamedRoute('create'), 'isEditNamedRoute' => $this->isNamedRoute('edit'),  'sidebar' => $sidebarVars, 'menu_switcher' => $menuSwitcherVars, 'menu_three' => $model, 'forms' => $this->getForms(), 'canAttachMedia' => $enabled_features['media']]);
    }
}
