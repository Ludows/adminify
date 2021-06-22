<?php
namespace Ludows\Adminify\Actions;

use Ludows\Adminify\Libs\Actionable;

class Post extends Actionable
{
    public function getView() {
        //you can overwrite parent view
        $r = $this->getRequest();
        return $r->exists('missing_translations') ? 'layouts.admin.actionable.missing-translations' : parent::getView();
    }
    public function handle() {

        $datas = $this->getDatas();
        $r = $this->getRequest();
        $m = $this->getModel();

        if($m->isMultiLangModel()) {
            $missing = $m->getNeededTranslations();
            if(count($missing) > 0 && $r->exists('missing_translations')) {
                foreach ($missing as $miss) {
                    # code...
                    $this->add('edit_'.$miss, [
                        'template' =>  'actions.edit',
                        'vars' => [
                            'url' => route('posts.edit', ['post' => $m->id, 'lang' => $r->useMultilang ? $miss : '']),
                            'name' => 'posts'
                        ]
                    ]);
                }
            }
        }
        if(!$r->exists('missing_translations')) {
            $this->add('edit', [
                'template' => 'actions.edit',
                'vars' => [
                    'url' => route('posts.edit', ['post' => $m->id, 'lang' => $r->useMultilang ? $miss : '']),
                    'name' => 'posts'
                ]
            ]);
            $this->add('seo', [
                'template' => 'actions.seo',
                'vars' => [
                    'editParam' => $datas['singular'],
                    'id' => $datas['pageId'],
                    'name' => 'posts'
                ]
            ]);
            $this->add('delete', [
                'template' => 'actions.delete',
                'vars' => [
                    'form' => $datas['form'],
                ]
            ]);
        }
    }
}
