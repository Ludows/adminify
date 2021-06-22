<?php
namespace Ludows\Adminify\Actions;

use Ludows\Adminify\Libs\Actionable;

class Users extends Actionable
{
    public function handle() {

        $datas = $this->getDatas();
        $r = $this->getRequest();
        $m = $this->getModel();

        $this->add('edit', [
            'template' => 'actions.edit',
            'vars' => [
                'url' => route('users.edit', ['user' => $m->id, 'lang' => $r->useMultilang ? $r->lang : '']),
                'name' => 'users'
            ]
        ]);
        $this->add('delete', [
            'template' => 'actions.delete',
            'vars' => [
                'form' => $datas['form'],
            ]
        ]);
    }
}
