<?php

namespace Ludows\Adminify\Dropdowns;

use Ludows\Adminify\Libs\Dropdowns;

class Media extends Dropdowns
{
    public function handle() {

        $datas = $this->getDatas();
        $r = $this->getRequest();
        $m = $this->getModels();

        $this->add('edit', [
            'template' => 'adminify::actions.edit',
            'vars' => [
                'url' => route('medias.edit', ['media' => $m->id, 'lang' => $r->useMultilang ? $r->lang : '']),
                'name' => 'medias'
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
