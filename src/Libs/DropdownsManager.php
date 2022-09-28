<?php

namespace Ludows\Adminify\Libs;
use Ludows\Adminify\Libs\Dropdown;
use App\Adminify\Forms\DeleteCrud;
use App\Adminify\Forms\CopyCrud;

class DropdownsManager
{
    public function __construct($models, $datas = [])
    {
        $this->dropdowns = [];
        $this->view = view();
        $this->datas = isset($datas) ? $datas : null;
        $this->request = request();
        $this->models = isset($models) ? $models : [];

        $this->handle();
    }

    public function setDefaults() {
        return [
            'template' => 'adminify::layouts.admin.actionable.dropdown-item',
            'vars' => []
        ];
    }
    public function getRequest() {
        return $this->request;
    }
    public function getDatas() {
        return $this->datas;
    }
    public function hasDatas() {
        return $this->datas != null;
    }
    public function getDropdowns() {
        return $this->dropdowns;
    }
    public function getModels() {
        return $this->models;
    }
    public function exists($name = '') {
        return array_key_exists( $name, $this->getDropdowns() );
    }
    public function hasModels() {
        return $this->model != [];
    }
    public function getDropdown($name = '') {
        return $this->dropdowns[$name];
    }
    public function setDropdown($name = '', $params = []) {

        if(!$this->exists($name)) {
            $d = new Dropdown();
        }
        else {
            $d = $this->getDropdown($name);
        }

        $d = $d->setItem($params);

        $this->dropdowns[$name] = $d;
        return $this;
    }
    public function removeDropdown($index = 0) {
        unset($this->dropdowns[$index]);
        return $this;
    }
    public function add($name = '', $params = []) {
        $this->setDropdown($name, array_merge($this->setDefaults(), $params));
        return $this;
    }
    public function getView() {
        return 'adminify::layouts.admin.dropdowns.dropdown';
    }
    public function remove($index = 0) {
        $this->removeDropdown($index);
        return $this;
    }
    public function setDefaultsActions() {
        $r = $this->getRequest();
        $models = $this->getModels();

        $form = app('Kris\LaravelFormBuilder\FormBuilder');

        foreach ($models as $m) {

            $singular = singular( $m->getTable() );
            $plurial = plural($singular);

            $this->add('dropdown_'.$m->id, [
                'template' => 'adminify::layouts.admin.dropdowns.extends.edit',
                'vars' => [
                    'url' => route($plurial.'.edit', [$singular => $m->id, 'lang' => $r->useMultilang ? $r->lang : '']),
                    'name' => $plurial
                ]
            ]);

            if(is_trashable_model($m) && $m->{$m->status_key} != status()::TRASHED_ID) {
                $this->add('dropdown_'.$m->id, [
                    'template' => 'adminify::layouts.admin.dropdowns.extends.trash',
                    'vars' => [
                        'url' => route('trash', ['type' => titled($singular), 'id' => $m->id]),
                        'name' => $plurial
                    ]
                ]);
            }

            if(is_content_type_model($m)) {
                $this->add('dropdown_'.$m->id, [
                    'template' => 'adminify::layouts.admin.dropdowns.extends.seo',
                    'vars' => [
                        'url' => route('seo.edit', ['type' => titled($singular), 'id' => $m->id, 'lang' => $r->useMultilang ? $r->lang : '']),
                        'name' => 'seo'
                    ]
                ]);
            }
            

            $this->add('dropdown_'.$m->id, [
                'template' => 'adminify::layouts.admin.dropdowns.extends.copy',
                'vars' => [
                    'form' => $form->create(CopyCrud::class, [
                        'method' => 'POST',
                        'url' => route('copy.entity', [ 'type' => lowercase($singular), 'id' => $m->id])
                    ])
                ]
            ]);

            $this->add('dropdown_'.$m->id, [
                'template' => 'adminify::layouts.admin.dropdowns.extends.delete',
                'vars' => [
                    'form' => $form->create(DeleteCrud::class, [
                        'method' => 'DELETE',
                        'url' => route($plurial.'.destroy', [$singular => $m->id])
                    ])
                ]
            ]);
        }

    }
    public function handle() {
        $datas = $this->getDatas();

        $models = $this->getModels();

        if(count($models) > 0 && is_translatable_model($models[0])) {
            check_traductions($models);
        }
        
        $this->setDefaultsActions();
    }
    public function render($index) {

        if($index != null) {
            $dropdowns = [$this->getDropdown('dropdown_'.$index)];
        }
        else {
            $dropdowns = $this->getDropdowns();
        }

        // dd($dropdowns);

        $tpl = $this->getView();
        $compiled = $this->view->make($tpl, ['dropdowns' => $dropdowns]);
        return $compiled;
    }
}
