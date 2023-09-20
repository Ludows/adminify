<?php
namespace Ludows\Adminify\Dropdowns;

use Ludows\Adminify\Libs\DropdownsManager;
use Ludows\Adminify\Forms\DeleteCrud;

class FormTraces extends DropdownsManager
{
    public function handle() {

        parent::handle();
        $r = $this->getRequest();
        $models = $this->getModels();
        foreach ($models as $m) {
            # code...
            //bounded by request
                $this->add('dropdown_'.$m->id, [
                    'template' => 'adminify::layouts.admin.dropdowns.extends.show',
                    'vars' => [
                        'url' => route('forms.traces.show', ['trace' => $m->id, 'lang' => $r->useMultilang ? $r->lang : '' ]),
                        'name' => 'traces',
                        'id' => $m->id
                    ]
                ]);
        }

    }
}
