<?php

namespace Ludows\Adminify\Actions;

use Ludows\Adminify\Libs\Actionable;

class Media extends Actionable
{
    public function handle() {

        $datas = $this->getDatas();
        $r = $this->getRequest();
        $m = $this->getModel();

        $this->add('edit', [
            'template' => 'actions.edit',
            'vars' => [
                'url' => route('medias.edit', ['media' => $m->id, 'lang' => $r->useMultilang ? $r->lang : '']),
                'name' => 'medias'
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
