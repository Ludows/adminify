<?php
namespace Ludows\Adminify\Dropdowns;

use Ludows\Adminify\Libs\DropdownsManager;
use Ludows\Adminify\Forms\DeleteCrud;

class Mail extends DropdownsManager
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
                    'template' => 'adminify::layouts.admin.dropdowns.extends.edit',
                    'vars' => [
                        'url' => route('mails.edit', ['mail' => $m->id, 'lang' => $r->useMultilang ? $r->lang : '']),
                        'name' => 'mails'
                    ]
                ]);
                $this->add('dropdown_'.$m->id, [
                    'template' => 'adminify::layouts.admin.dropdowns.extends.sendMail',
                    'vars' => [
                        'url' => route('mails.send', ['mail' => $m->id, 'lang' => $r->useMultilang ? $r->lang : '']),
                        'name' => 'mails'
                    ]
                ]);
                $this->add('dropdown_'.$m->id, [
                    'template' => 'adminify::layouts.admin.dropdowns.extends.delete',
                    'vars' => [
                        'form' => $form->create(DeleteCrud::class, [
                            'method' => 'DELETE',
                            'url' => route('mails.destroy', ['mail' => $m->id])
                        ])
                    ]
                ]);
        }
        
    }
}
