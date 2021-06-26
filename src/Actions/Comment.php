<?php

namespace Ludows\Adminify\Actions;

use Ludows\Adminify\Libs\Actionable;

class Comment extends Actionable
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
