<?php
namespace Ludows\Adminify\Actions;

use Ludows\Adminify\Libs\Actionable;

class Translations extends Actionable
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
                            'url' => route('traductions.edit', ['traduction' => $m->id, 'lang' => $r->useMultilang ? $miss : '']),
                            'name' => 'traductions'
                        ]
                    ]);
                }
            }
        }
        if(!$r->exists('missing_translations')) {
            $this->add('edit', [
                'template' => 'adminify::actions.edit',
                'vars' => [
                    'editParam' => $datas['singular'],
                    'id' => $datas['pageId'],
                    'name' => 'traductions'
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
