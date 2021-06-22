<?php

namespace Ludows\Adminify\Actions;

use Ludows\Adminify\Libs\Actionable;

class Page extends Actionable
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
                            'url' => route('pages.edit', ['page' => $m->id, 'lang' => $r->useMultilang ? $miss : '']),
                            'name' => 'pages'
                        ]
                    ]);
                }
            }
        }

        if(!$r->exists('missing_translations')) {
            $this->add('edit', [
                'template' => 'actions.edit',
                'vars' => [
                    'url' => route('pages.edit', ['page' => $m->id, 'lang' => $r->useMultilang ? $r->lang : '']),
                    'name' => 'pages'
                ]
            ]);
            $this->add('seo', [
                'template' => 'actions.seo',
                'vars' => [
                    'url' => route('pages.edit', ['page' => $m->id, 'lang' => $r->useMultilang ? $r->lang : '', 'seo']),
                    'name' => 'pages'
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
