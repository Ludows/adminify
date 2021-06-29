<?php
namespace Ludows\Adminify\Actions;

use Ludows\Adminify\Libs\Dropdowns;

class Users extends Dropdowns
{
    public function handle() {

        $datas = $this->getDatas();
        $r = $this->getRequest();
        $m = $this->getModels();

        $this->add('edit', [
            'template' => 'adminify::actions.edit',
            'vars' => [
                'url' => route('users.edit', ['user' => $m->id, 'lang' => $r->useMultilang ? $r->lang : '']),
                'name' => 'users'
            ]
        ]);
        $this->add('delete', [
            'template' => 'adminify::actions.delete',
            'vars' => [
                'form' => $datas['form'],
            ]
        ]);
    }
}
