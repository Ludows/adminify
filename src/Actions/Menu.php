<?php

namespace Ludows\Adminify\Actions;

use Ludows\Adminify\Libs\Actionable;

class Menu extends Actionable
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
                            'url' => route('menus.edit', ['menu' => $m->id, 'lang' => $r->useMultilang ? $miss : '']),
                            'name' => 'menus'
                        ]
                    ]);
                }
            }
        }

        if(!$r->exists('missing_translations')) {
            $this->add('edit', [
                'template' => 'actions.edit',
                'vars' => [
                    'url' => route('menus.edit', ['menu' => $m->id, 'lang' => $r->useMultilang ? $miss : '']),
                    'name' => 'menus'
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
