<?php
namespace Ludows\Adminify\Dropdowns;

use Ludows\Adminify\Libs\DropdownsManager;
use Ludows\Adminify\Forms\DeleteCrud;
class Translations extends DropdownsManager
{
    public function getView() {
        //you can overwrite parent view
        $r = $this->getRequest();
        return $r->exists('missing_translations') ? 'adminify::layouts.admin.dropdowns.missing-translations' : parent::getView();
    }
    public function handle() {

        $datas = $this->getDatas();
        $r = $this->getRequest();
        $models = $this->getModels();

        $form = app('Kris\LaravelFormBuilder\FormBuilder');

        foreach ($models as $m) {
            if($m->isMultiLangModel()) {
                
                $m->checkForTraduction();

                $missing = $m->getNeededTranslations();
                if(count($missing) > 0 && $r->exists('missing_translations')) {
                    foreach ($missing as $miss) {
                        # code...
                        $this->add('dropdown_'.$m->id, [
                            'template' =>  'adminify::layouts.admin.dropdowns.extends.edit',
                            'vars' => [
                                'url' => route('traductions.edit', ['traduction' => $m->id, 'lang' => $r->useMultilang ? $miss : '']),
                                'name' => 'traductions'
                            ]
                        ]);
                    }
                }
            }
            if(!$r->exists('missing_translations')) {
                $this->add('dropdown_'.$m->id, [
                    'template' => 'adminify::layouts.admin.dropdowns.extends.edit',
                    'vars' => [
                        'url' => route('traductions.edit', ['traduction' => $m->id, 'lang' => $r->useMultilang ? $miss : '']),
                        'name' => 'traductions'
                    ]
                ]);
                $this->add('dropdown_'.$m->id, [
                    'template' => 'adminify::layouts.admin.dropdowns.extends.delete',
                    'vars' => [
                        'form' => $form->create(DeleteCrud::class, [
                            'method' => 'DELETE',
                            'url' => route('traductions.destroy', ['traduction' => $m->id])
                        ])
                    ]
                ]);
            }
        }
        
    }
}
