<?php
namespace Ludows\Adminify\Dropdowns;

use Ludows\Adminify\Libs\DropdownsManager;
use Ludows\Adminify\Forms\DeleteCrud;

use App\Adminify\Models\Statuses;

class Post extends DropdownsManager
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
                        'url' => route('posts.edit', ['post' => $m->id, 'lang' => $r->useMultilang ? $r->lang : '']),
                        'name' => 'posts'
                    ]
                ]);
                if(is_trashable_model($m) && $m->status_id != Statuses::TRASHED_ID) {
                    $this->add('dropdown_'.$m->id, [
                        'template' => 'adminify::layouts.admin.dropdowns.extends.trash',
                        'vars' => [
                            'url' => route('trash', ['type' => 'Post', 'id' => $m->id]),
                            'name' => 'posts'
                        ]
                    ]);
                }
                $this->add('dropdown_'.$m->id, [
                    'template' => 'adminify::layouts.admin.dropdowns.extends.seo',
                    'vars' => [
                        'url' => route('seo.edit', ['type' => 'Post', 'id' => $m->id, 'lang' => $r->useMultilang ? $r->lang : '']),
                        'name' => 'seo'
                    ]
                ]);
                $this->add('dropdown_'.$m->id, [
                    'template' => 'adminify::layouts.admin.dropdowns.extends.delete',
                    'vars' => [
                        'form' => $form->create(DeleteCrud::class, [
                            'method' => 'DELETE',
                            'url' => route('posts.destroy', ['post' => $m->id])
                        ])
                    ]
                ]);
        }

        
    }
}
