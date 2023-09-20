<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
use Kris\LaravelFormBuilder\Field;
use App\Adminify\Models\Category;

class CreateCategory extends BaseForm
{
    public function buildForm()
    {
        $categories = $this->hydrateSelect();
        $m = $this->getModel();
        $r = $this->getRequest();
        $enabled_features = $this->getFeaturesSite();

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
            $this->addMediaLibraryPicker('media_id', []);
        }
       
        $this->addCategories('parent_id', [
            'empty_value' => '',
            'withCreate' => false,
            'label' => __('admin.form.parent_id'),
            'select2options' => [
                'placeholder' => __('admin.select_parentcategory'),
            ]
        ]);

        $this->addUserId('user_id', []);
        
        $this->addSubmit();
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
