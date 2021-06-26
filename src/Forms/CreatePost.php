<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;
use Ludows\Adminify\Models\Category;


class CreatePost extends Form
{
    public function buildForm()
    {
        $hydrator = $this->hydrateSelect();

        $this
            ->add('title', Field::TEXT, [])
            ->add('content', 'laraberg', []);
            // if(count($categories) > 0) {
                $this->add('categories_id', 'select2', [
                    'empty_value' => '',
                    'withCreate' => true,
                    'modal' => 'adminify::layouts.admin.modales.createCategory',
                    'choices' => $hydrator['categories'],
                    'selected' => $hydrator['selected'],
                    'attr' => ['multiple' => 'multiple'],
                    'select2options' => [
                        'placeholder' => 'Sélectionner vos Catégories',
                        'multiple' => true,
                        'width' => '100%'
                    ]
                ]);
            // }
            $this->add('media_src', 'lfm',[
                'label_show' => false,
            ]);
            $this->add('submit', 'submit', ['label' => 'Créer', 'attr' => ['class' => 'btn btn-default']]);
    }

    public function hydrateSelect() {
        $categories = '';
        $hasModel = $this->getModel();
        // dd($hasModel);
        $categories = Category::get()->pluck('title' ,'id');
        $selecteds = '';

        if(isset($hasModel->categories) && count($hasModel->categories->all()) > 0) {
            // on a une selection
            $selecteds = $hasModel->categories()->get()->pluck('id')->all();

            // $selecteds = $selecteds->all();
        }

        return [ 'categories' => $categories->all(), 'selected' => $selecteds];
    }
}
