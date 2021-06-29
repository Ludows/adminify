<?php
namespace Ludows\Adminify\Dropdowns;

use Ludows\Adminify\Libs\Dropdowns;
use Ludows\Adminify\Forms\DeleteCrud;

class Users extends Dropdowns
{
    public function handle() {

        $form = app('Kris\LaravelFormBuilder\FormBuilder');

        $datas = $this->getDatas();
        $r = $this->getRequest();
        $models = $this->getModels();

        foreach ($models as $m) {
            # code...            
            $this->add('edit_'.$m->id, [
                'template' => 'adminify::actions.edit',
                'vars' => [
                    'url' => route('users.edit', ['user' => $m->id, 'lang' => $r->useMultilang ? $r->lang : '']),
                    'name' => 'users'
                ]
            ], 'group_'.$m->id);
            $this->add('delete_'.$m->id, [
                'template' => 'adminify::actions.delete',
                'vars' => [
                    'form' => $form->create(DeleteCrud::class, [
                        'method' => 'DELETE',
                        'url' => route('users.destroy', ['user' => $m->id])
                    ])
                ]
            ], 'group_'.$m->id);
        }
    }
}
