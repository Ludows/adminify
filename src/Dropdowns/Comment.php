<?php

namespace Ludows\Adminify\Dropdowns;

use Ludows\Adminify\Libs\Dropdowns;

class Comment extends Dropdowns
{
    public function handle() {

        $datas = $this->getDatas();
        $r = $this->getRequest();
        $m = $this->getModel();

        $this->add('edit', [
            'template' => 'adminify::actions.edit',
            'vars' => [
                'url' => route('comments.edit', ['comment' => $m->id, 'lang' => $r->useMultilang ? $r->lang : '']),
                'name' => 'comments'
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
