<?php

namespace Ludows\Adminify\Libs;

use App\Adminify\Models\Menu;
use App\Adminify\Models\MenuItem;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Adminify\Forms\MenuSwitcher;
use App\Adminify\Forms\CreateMenu;
use App\Adminify\Forms\UpdateMenu;
use App\Adminify\Forms\SetItemsToMenu as SetItemsToMenuBaseMenuBuilder;
use App\Adminify\Forms\DeleteCrud;


class MenuBuilder
{
    use FormBuilderTrait;
    public $appendable_forms = [];
    public function __construct() {
        $this->boot();
        $this->config = config('site-settings');
        $this->model = null;
        $this->inertia_vars = inertia()->getShared();

        $this->booted();
    }
    public function defaultsForms() {
        return [
            'switcher' => MenuSwitcher::class,
            'create_menu' => CreateMenu::class,
            'update_menu' => UpdateMenu::class,
            'delete_crud' => DeleteCrud::class
        ];
    }
    public function boot() {}
    public function booted() {}
    public function setModel($model) {
        $this->model = $model;
    }
    public function getModel() {
        return $this->model;
    }
    public function loadForms($arrayOfForms = []) {
        $loadedForms = [];
        $restricted_forms_on_create = [
            'update_menu',
            'set_to_items',
            'delete_crud',
        ];
        $isCreate = $this->inertia_vars['isCreate'];
        $arrayOfForms = array_filter($arrayOfForms, function($cls, $name) use ($restricted_forms_on_create, $isCreate) {
            if(!$isCreate) {
                return true;
            }
            return !in_array($name, $restricted_forms_on_create);
        }, ARRAY_FILTER_USE_BOTH);

        // dd($arrayOfForms);

        foreach ($arrayOfForms as $name => $classStringPath) {
            # code...
            $clsForm = $this->form($classStringPath, [
                'model' => $name == 'update_menu' ? $this->getModel() : []
            ]);
            $loadedForms[$name] = $clsForm->toArray();
        }

        if( $this->inertia_vars['isEdit'] ) {
            $loadedForms['delete_crud']['formOptions'] = array_merge(
                $loadedForms['delete_crud']['formOptions'],
                [
                    'url' => route('menus.update', ['menu' => $this->inertia_vars['model']->id ])
                ]
            );
        }
        
        return $loadedForms;
    }
    public function createSidebarForms($forms = [], $arrayOfModels = []) {
        $created_forms = [];

        foreach ($arrayOfModels as $name => $modelPaginated) {
            # code...
            $local_form = $this->form(SetItemsToMenuBaseMenuBuilder::class, [
                'method' => 'POST',
                'url' => route('menus.setItemsToMenu', ['type' => $name])
            ]);

            $collectionOfItems = $modelPaginated->getCollection();

            $firstModel = $collectionOfItems->first();
            $pluckFields = $collectionOfItems->pluck($firstModel->searchable_label, 'id'); 

            $local_form->modify('items', 'select2', [
                'choices' => $pluckFields
            ]);
            // $created_forms['bounded_'.$name] = ;

            $created_forms[ $name ] = $local_form->toArray();
        }

        // $formBuilder = app()->make(FormBuilder::class);
        
        // $created_forms[ 'custom' ] = $formBuilder->createByArray([
        //     ['type' => 'text', 'options' => [], 'name' => 'title'],
        //     ['type' => 'text', 'options' => [], 'name' => 'url'],
        //     ['type' => 'checkbox', 'options' => [], 'name' => 'open_new_tab']
        // ],[
        //     'method' => 'POST',
        //     'url' => route('menus.setItemsToMenu', ['type' => 'custom'])
        // ])->toArray();

        
        return $created_forms;
    }
    public function getModels() {
        $contents = [];
        $defaults_content_types = get_content_types();
        $inertia_vars = $this->inertia_vars;
        $config = $this->getConfig();
        $sidebar_models = $config['menu-builder']['sidebar'];

        $allModels = array_merge( $defaults_content_types , $sidebar_models );

        foreach ($allModels as $name => $modelClassString) {
            # code...
            $m = new $modelClassString;
            if($inertia_vars['useMultilang']) {
                 $m = $m->lang($inertia_vars['currentLang'])->paginate( $config['menu-builder']['paginate']['limit'] ?? 5 );
            }
            else {
                $m = $m->paginate( $config['menu-builder']['paginate']['limit'] ?? 5 );
            }

            $contents[ lowercase($name) ] = $m; 
        }
        return $contents;
    }
    public function getForms() {

        $defaults = $this->defaultsForms();
        $appends = $this->appendable_forms;

        $allForms = array_merge($defaults, $appends);

        $loaded = $this->loadForms($allForms);

        return $loaded;
    }
    public function getRequest() {
        return $this->request;
    }
    public function getConfig() {
        return $this->config;
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
    public function toArray() {
        return $this->_run();
    }
    public function _run() {
        $defaults = [
            'forms' => [],
            'sidebar_forms' => []
        ];
        $forms = $this->getForms();
        $models = $this->getModels();
        $createdForms = $this->createSidebarForms($forms, $models);


        $final = array_merge( $defaults , [ 'forms' => $forms, 'sidebar_forms' => $createdForms ]);
        return $final;
    }
}
