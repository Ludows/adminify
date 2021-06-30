<?php
namespace Ludows\Adminify\Dropdowns;

use Ludows\Adminify\Libs\DropdownsManager;
use Ludows\Adminify\Libs\Dropdown;
use Ludows\Adminify\Forms\DeleteCrud;

class Users extends DropdownsManager
{
    public function handle() {

        $form = app('Kris\LaravelFormBuilder\FormBuilder');

        $datas = $this->getDatas();
        $r = $this->getRequest();
        $models = $this->getModels();

        foreach ($models as $m) {
            # code...            
            $this->add('dropdown_'.$m->id, [
                'template' => 'adminify::actions.edit',
                'vars' => [
                    'url' => route('users.edit', ['user' => $m->id, 'lang' => $r->useMultilang ? $r->lang : '']),
                    'name' => 'users'
                ]
            ]);
            $this->add('dropdown_'.$m->id, [
                'template' => 'adminify::actions.delete',
                'vars' => [
                    'form' => $form->create(DeleteCrud::class, [
                        'method' => 'DELETE',
                        'url' => route('users.destroy', ['user' => $m->id])
                    ])
                ]
            ]);
        }
    }
}
