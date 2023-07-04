<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
use Kris\LaravelFormBuilder\Field;

class MenuSwitcher extends BaseForm
{
    public function buildForm()
    {
        $inertia = inertia();
        $useMultilang = $inertia->getShared('useMultilang');
        $currentLang = $inertia->getShared('currentLang');
        $isEdit = $inertia->getShared('isEdit');
        $m = null;
        if($isEdit) {
            $m = model('Menu');
            $model_from_request = $inertia->getShared('model');
            $m = $useMultilang ? $m->where('id' ,'!=', $model_from_request->id)->lang($currentLang)->get() : $m->where('id' ,'!=', $model_from_request->id)->get();
        }
        
        $choices = [];
        
        if(!empty($m)) {
            $choices = $m->pluck('title', 'id');
        }
        // Add fields here...
        $this->add('menus', Field::SELECT, [
            'empty_value' => __('select.menu'),
            'label' => __('admin.form.menus'),
            'choices' => $choices,
            'selected' => '',
            'attr' => [],
        ]);
        $this->addSubmit(['label' => __('admin.form.select')]);
    }
}
