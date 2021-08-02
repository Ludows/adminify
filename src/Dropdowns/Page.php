<?php

namespace Ludows\Adminify\Dropdowns;

use Ludows\Adminify\Libs\DropdownsManager;
use Ludows\Adminify\Forms\DeleteCrud;

use App\Models\Statuses;
class Page extends DropdownsManager
{
    public function handle() {

        $datas = $this->getDatas();

        $r = $this->getRequest();
        $models = $this->getModels();

        $form = app('Kris\LaravelFormBuilder\FormBuilder');

        if(count($models) > 0 && is_translatable_model($models[0])) {
            check_traductions($models);
        }

        foreach ($models as $m) {
    
                $this->add('dropdown_'.$m->id, [
                    'template' => 'adminify::layouts.admin.dropdowns.extends.edit',
                    'vars' => [
                        'url' => route('pages.edit', ['page' => $m->id, 'lang' => $r->useMultilang ? $r->lang : '']),
                        'name' => 'pages'
                    ]
                ]);
                if(is_trashable_model($m) && $m->status_id != Statuses::TRASHED_ID) {
                    $this->add('dropdown_'.$m->id, [
                        'template' => 'adminify::layouts.admin.dropdowns.extends.trash',
                        'vars' => [
                            'url' => route('trash', ['type' => 'pages', 'id' => $m->id]),
                            'name' => 'pages'
                        ]
                    ]);
                }
                $this->add('dropdown_'.$m->id, [
                    'template' => 'adminify::layouts.admin.dropdowns.extends.seo',
                    'vars' => [
                        'url' => route('pages.edit', ['page' => $m->id, 'lang' => $r->useMultilang ? $r->lang : '', 'seo']),
                        'name' => 'pages'
                    ]
                ]);
                $this->add('dropdown_'.$m->id, [
                    'template' => 'adminify::layouts.admin.dropdowns.extends.delete',
                    'vars' => [
                        'form' => $form->create(DeleteCrud::class, [
                            'method' => 'DELETE',
                            'url' => route('pages.destroy', ['page' => $m->id])
                        ])
                    ]
                ]);
        }
        


    }
}
