<?php
namespace Ludows\Adminify\Dropdowns;

use Ludows\Adminify\Libs\Dropdowns;
use Ludows\Adminify\Forms\DeleteCrud;
use Kris\LaravelFormBuilder\FormBuilder;

class Users extends Dropdowns
{
    public function handle(FormBuilder $formbuilder) {

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
            ]);
            $this->add('delete_'.$m->id, [
                'template' => 'adminify::actions.delete',
                'vars' => [
                    'form' => $formbuilder->create(DeleteCrud::class, [
                        'method' => 'DELETE',
                        'url' => route('users.destroy', ['user' => $m->id])
                    ])
                ]
            ]);
        }
    }
}
