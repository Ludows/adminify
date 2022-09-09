<?php
namespace Ludows\Adminify\Dropdowns;

use Ludows\Adminify\Libs\DropdownsManager;
use Ludows\Adminify\Forms\DeleteCrud;

class FormTraces extends DropdownsManager
{
    public function handle() {

        $datas = $this->getDatas();
        $r = $this->getRequest();
        $models = $this->getModels();

        $form = app('Kris\LaravelFormBuilder\FormBuilder');

        // $theForm = $r->routeParameters['form'];

        if(count($models) > 0 && is_translatable_model($models[0])) {
            check_traductions($models);
        }


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
                $this->add('dropdown_'.$m->id, [
                    'template' => 'adminify::layouts.admin.dropdowns.extends.delete',
                    'vars' => [
                        'form' => $form->create(DeleteCrud::class, [
                            'method' => 'DELETE',
                            'url' => route('forms.traces.destroy', ['trace' => $m->id])
                        ])
                    ]
                ]);
        }

    }
}
