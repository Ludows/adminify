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
            'Component' => 'dropdown-item',
            'Vars' => []
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
        $inertia = inertia();
        $shareds = $inertia->getShared();


        $form = app('Kris\LaravelFormBuilder\FormBuilder');

        foreach ($models as $m) {

            $singular = singular( $m->getTable() );
            $plurial = plural($singular);

            $this->add('dropdown_'.$m->id, [
                'Component' => 'edit-item',
                'Vars' => [
                    'url' => route('admin.'.$plurial.'.edit', [$singular => $m->id, 'lang' => $shareds['useMultilang'] ? $shareds['currentLang'] : '']),
                    'name' => $plurial
                ]
            ]);

            if(is_trashable_model($m) && $m->{$m->status_key} != status()::TRASHED_ID) {
                $trashForm = $form->create(DeleteCrud::class, [
                    'method' => 'POST',
                    'url' => route('admin.trash', ['type' => titled($singular), 'id' => $m->id])
                ]);

                $trashForm->modify('submit', 'submit', [
                    'label' => __('admin.trash')
                ]);

                $this->add('dropdown_'.$m->id, [
                    'Component' => 'trash-item',
                    'Vars' => [
                        'form' => $trashForm->toArray(),
                        'name' => 'trash'
                    ]
                ]);
            }

            if(is_trashable_model($m) && $m->{$m->status_key} != status()::PUBLISHED_ID) {
                $updateStatusForm = $form->create(DeleteCrud::class, [
                    'method' => 'PUT',
                    'url' => route('admin.trash', ['type' => titled($singular), 'id' => $m->id])
                ]);

                $updateStatusForm->modify('submit', 'submit', [
                    'label' => __('admin.update_status_published')
                ]);

                $this->add('dropdown_'.$m->id, [
                    'Component' => 'update-item',
                    'Vars' => [
                        'form' => $updateStatusForm->toArray(),
                        'name' => 'update-status'
                    ]
                ]);
            }

            if(is_content_type_model($m) && $m->allowSitemap) {
                $this->add('dropdown_'.$m->id, [
                    'Component' => 'seo-item',
                    'Vars' => [
                        'url' => route('admin.seo.edit', ['type' => titled($singular), 'id' => $m->id, 'lang' => $shareds['useMultilang'] ? $shareds['currentLang'] : '']),
                        'name' => 'seo'
                    ]
                ]);
            }

            $copyForm = $form->create(CopyCrud::class, [
                'method' => 'POST',
                'url' => route('admin.copy.entity', [ 'type' => lowercase($singular), 'id' => $m->id])
            ]);

            $deleteForm = $form->create(DeleteCrud::class, [
                'method' => 'DELETE',
                'url' => route('admin.'.$plurial.'.destroy', [$singular => $m->id]),
            ]);
            

            $this->add('dropdown_'.$m->id, [
                'Component' => 'copy-item',
                'Vars' => [
                    'form' => $copyForm->toArray(),
                    'name' => 'copy'
                ]
            ]);

            $this->add('dropdown_'.$m->id, [
                'Component' => 'delete-item',
                'Vars' => [
                    'form' => $deleteForm->toArray(),
                    'name' => 'delete'
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
