<?php
namespace Ludows\Adminify\Dropdowns;

use Ludows\Adminify\Libs\DropdownsManager;
use Ludows\Adminify\Forms\DeleteCrud;

class FormEntries extends DropdownsManager
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
            # code...
                $this->add('dropdown_'.$m->id, [
                    'template' => 'adminify::layouts.admin.dropdowns.extends.sendMail',
                    'vars' => [
                        'url' => route('mails.send', ['mail' => $m->id, 'lang' => $r->useMultilang ? $r->lang : '']),
                        'name' => 'mails',
                        'id' => $m->id
                    ]
                ]);
                $this->add('dropdown_'.$m->id, [
                    'template' => 'adminify::layouts.admin.dropdowns.extends.delete',
                    'vars' => [
                        'form' => $form->create(DeleteCrud::class, [
                            'method' => 'DELETE',
                            'url' => route('forms.destroy', ['form' => $m->id])
                        ])
                    ]
                ]);
        }
        
    }
}
