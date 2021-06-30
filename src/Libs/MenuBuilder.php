<?php

namespace Ludows\Adminify\Libs;

use Ludows\Adminify\Models\Menu;
use Ludows\Adminify\Models\MenuItem;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Http\Controllers\MenuController;
use Ludows\Adminify\Forms\MenuSwitcher;
use Ludows\Adminify\Forms\CreateMenu;
use Ludows\Adminify\Forms\UpdateMenu;
use Ludows\Adminify\Forms\SetItemsToMenu;
use Ludows\Adminify\Forms\DeleteCrud;

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

        $formSetItemsToMenu = $this->form(SetItemsToMenu::class, [
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

            $formCreateMenu->addBefore('submit', 'suppress_menu', 'button', ['label' => __('suppress.menu') , 'attr' => ['class' => 'btn btn-danger']]);
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
        if($defaultsVars['multilang']) {
            $menus = Menu::lang($defaultsVars['lang'])->all();
        }
        else {
            $menus = Menu::all();
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
                $class_call = new $key;
                if(!array_key_exists($model, $defaultsVars['config']['menu-builder']['showAlways'])) {

                    if($defaultsVars['multilang']) {
                        $check_all_from_called_class = $class_call::lang($defaultsVars['lang'])->all();
                    }
                    else {
                        $check_all_from_called_class = $class_call->all();
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
                $tplDynamicForm = $this->form(SetItemsToMenu::class, [
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
                        'empty_value' => _i('select.'.$collectionName)
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


        $this->runHydratorForms([
            'sidebarVars' => $sidebarVars,
            'menuSwitcherVars' => $menuSwitcherVars,
            'menuThreeVars' => $menuThreeVars,
        ]);



        return view($view, ['isCreatedNamedRoute' => $this->isNamedRoute('create'), 'isEditNamedRoute' => $this->isNamedRoute('edit'),  'sidebar' => $sidebarVars, 'menu_switcher' => $menuSwitcherVars, 'menu_three' => $model, 'forms' => $this->getForms()]);
    }
}
