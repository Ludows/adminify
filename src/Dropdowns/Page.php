<?php

namespace Ludows\Adminify\Dropdowns;

use Ludows\Adminify\Libs\Dropdowns;

class Page extends Dropdowns
{
    public function getView() {
        //you can overwrite parent view
        $r = $this->getRequest();
        return $r->exists('missing_translations') ? 'adminify::layouts.admin.actionable.missing-translations' : parent::getView();
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
                        'template' =>  'adminify::actions.edit',
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
                'template' => 'adminify::actions.edit',
                'vars' => [
                    'url' => route('pages.edit', ['page' => $m->id, 'lang' => $r->useMultilang ? $r->lang : '']),
                    'name' => 'pages'
                ]
            ]);
            $this->add('seo', [
                'template' => 'adminify::actions.seo',
                'vars' => [
                    'url' => route('pages.edit', ['page' => $m->id, 'lang' => $r->useMultilang ? $r->lang : '', 'seo']),
                    'name' => 'pages'
                ]
            ]);
            $this->add('delete', [
                'template' => 'adminify::actions.delete',
                'vars' => [
                    'form' => $datas['form'],
                ]
            ]);
        }


    }
}
