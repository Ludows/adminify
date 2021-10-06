<?php
namespace Ludows\Adminify\Dropdowns;

use Ludows\Adminify\Libs\DropdownsManager;
use Ludows\Adminify\Forms\DeleteCrud;

class Users extends DropdownsManager
{
    public function handle() {

        $form = app('Kris\LaravelFormBuilder\FormBuilder');

        $datas = $this->getDatas();
        $r = $this->getRequest();
        $models = $this->getModels();
        $u = user();

        if(!$u->hasPermissionTo('edit_users')) {
            return false;       
        }

        foreach ($models as $m) {
            # code...   
                     
            $this->add('dropdown_'.$m->id, [
                'template' => 'adminify::layouts.admin.dropdowns.extends.edit',
                'vars' => [
                    'url' => route('users.edit', ['user' => $m->id, 'lang' => $r->useMultilang ? $r->lang : '']),
                    'name' => 'users'
                ]
            ]);
            
            if($u->hasPermissionTo('delete_users')) {
                $this->add('dropdown_'.$m->id, [
                    'template' => 'adminify::layouts.admin.dropdowns.extends.delete',
                    'vars' => [
                        'form' => $form->create(DeleteCrud::class, [
                            'method' => 'DELETE',
                            'url' => route('users.destroy', ['user' => $m->id])
                        ])
                    ]
                ]);      
            }
            
        }
    }
}
