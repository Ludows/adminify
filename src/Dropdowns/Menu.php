<?php

namespace Ludows\Adminify\Dropdowns;

use Ludows\Adminify\Libs\Dropdowns;

class Menu extends Dropdowns
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
                            'url' => route('menus.edit', ['menu' => $m->id, 'lang' => $r->useMultilang ? $miss : '']),
                            'name' => 'menus'
                        ]
                    ]);
                }
            }
        }

        if(!$r->exists('missing_translations')) {
            $this->add('edit', [
                'template' => 'adminify::actions.edit',
                'vars' => [
                    'url' => route('menus.edit', ['menu' => $m->id, 'lang' => $r->useMultilang ? $miss : '']),
                    'name' => 'menus'
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
