<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class SeoForm extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $m = $this->getModel();
        $enabled_features = get_site_key('enables_features');

        // dd($this->getSeoData('title', $s));
        $this->add('_seo', Field::HIDDEN, [
            'value' => '1'
        ])
        ->add('title', Field::TEXT, [
            'label' => __('admin.form.title'),
           'value' => $m->seoWith('title', false) ?? ''
        ])
        ->add('description', Field::TEXTAREA, [
            'label' => __('admin.form.description'),
            'value' => $m->seoWith('description', false) ?? ''
        ])
        ->add('keywords', Field::TEXT, [
            'label' => __('admin.form.keywords'),
            'value' => $m->seoWith('keywords', false) ?? ''
        ])
        ->add('robots', Field::SELECT, [
            'choices' => [
                'follow' => __('admin.form.yes'),
                'no-follow' => __('admin.form.no')
            ],
            'label' => __('admin.form.robots'),
            'selected' => $m->seoWith('robots', false) ?? ''
        ]);
        if(isset($enabled_features['media']) && $enabled_features['media']) { 
            $this->add('image', 'lfm', [
                'label' => __('admin.form.image'),
                'value' => $m->seoWith('image', false) ?? ''
            ]);
        }
        
        $this->add('submit', 'submit', ['label' => __('admin.form.save') , 'attr' => ['class' => 'btn btn-default']]);

    }
}
