<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;
use App\Adminify\Models\Category;

class CreateCategory extends Form
{
    public function buildForm()
    {
        $categories = $this->hydrateSelect();
        $m = $this->getModel();
        $r = $this->getRequest();
        $enabled_features = get_site_key('enables_features');

        // Add fields here...
        $this->add('title', Field::TEXT, [
            'label' => __('admin.form.title'),
            'label_attr' => ['class' => 'control-label', 'for' => 'cat_title'],
            'attr' => [
                'id' => 'cat_title'
            ],
        ]);
        // $options['fromAjax']
        if(isset($enabled_features['media']) && $enabled_features['media']) {
            $this->add('media_id', 'lfm', [
                'label_show' => false,
                'attr' => [
                    'value' => !is_array($m) && $m->media_id != 0 ? $m->media->path : null
                ]
            ]);
        }
       
        // if(count($categories) > 0) {
            $this->add('parent_id', 'select2', [
                'empty_value' => '',
                'withCreate' => false,
                'choices' => $categories,
                'selected' => '',
                'label' => __('admin.form.parent_id'),
                'attr' => [
                ],
                'select2options' => [
                    'multiple' => false,
                    'width' => '100%',
                    'placeholder' => __('admin.select_parentcategory')
                ]
            ]);
            $this->add('user_id', 'hidden', [
                'value' => user()->id
            ]);
        // }
        $this->add('submit', 'submit', ['label' => __('admin.form.create'), 'attr' => ['class' => 'btn btn-default']]);
    }
    public function hydrateSelect() {
        $categories = '';
        $hasModel = $this->getModel();

        if(is_array($hasModel) && count($hasModel) == 0) {
            $categories = Category::get()->pluck('title' ,'id');
            $categories = $categories->all();
        }
        else {
            // cas de l'update
            $categories = Category::where('id', '!=', $hasModel->id)->get()->pluck('title' ,'id');
            $categories = $categories->all();
        }

        return $categories;
    }
}
