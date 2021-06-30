<?php

namespace Ludows\Adminify\Dropdowns;

use Ludows\Adminify\Libs\DropdownsManager;
use Ludows\Adminify\Forms\DeleteCrud;

class Media extends DropdownsManager
{
    public function handle() {

        $datas = $this->getDatas();
        $r = $this->getRequest();
        $models = $this->getModels();

        $form = app('Kris\LaravelFormBuilder\FormBuilder');

        foreach ($models as $m) {
            $this->add('dropdown_'.$m->id, [
                'template' => 'adminify::layouts.admin.dropdowns.extends.edit',
                'vars' => [
                    'url' => route('medias.edit', ['media' => $m->id, 'lang' => $r->useMultilang ? $r->lang : '']),
                    'name' => 'medias'
                ]
            ]);
            $this->add('dropdown_'.$m->id, [
                'template' => 'adminify::layouts.admin.dropdowns.extends.delete',
                'vars' => [
                    'form' => $form->create(DeleteCrud::class, [
                        'method' => 'DELETE',
                        'url' => route('medias.destroy', ['media' => $m->id])
                    ])
                ]
            ]);
        }

        
    }
}
