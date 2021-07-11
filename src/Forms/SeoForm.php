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
                'follow' => 'Oui',
                'no-follow' => 'Non'
            ],
            'label' => __('admin.form.robots'),
            'selected' => $m->seoWith('robots', false) ?? ''
        ])
        ->add('image', 'lfm', [
            'label' => __('admin.form.image'),
            'value' => $m->seoWith('image', false) ?? ''
        ]);
        $this->add('submit', 'submit', ['label' => __('admin.create') , 'attr' => ['class' => 'btn btn-default']]);

    }
}
