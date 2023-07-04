<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;

class UpdateMenu extends BaseForm
{
    public function __construct()
    {
        $model = inertia()->getShared('model') ?? $this->getModel();
        if($model) {
            $newOptions = [
                'method' => 'PUT',
                'url' => route('menus.update', ['menu' => $model->id])
            ];
    
            $this->formOptions = array_merge($this->formOptions, $newOptions);
        }
    }
    public function buildForm()
    {
        // Add fields here...
        $this->compose('App\Adminify\Forms\CreateMenu');

        $this->addBefore('submit', 'items', 'collection', [
            'type' => 'form',
            'prefer_input' => true,
            'empty_row' => false,
            'label' => false,
            'options' => [    // these are options for a single type
                'class' => 'Ludows\Adminify\Forms\MenuThreeItemForm',
            ]
        ]);
    }
}
