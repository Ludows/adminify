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
           'value' => $m->seoWith('title', false) ?? ''
        ])
        ->add('description', Field::TEXTAREA, [
            'value' => $m->seoWith('description', false) ?? ''
        ])
        ->add('keywords', Field::TEXT, [
            'value' => $m->seoWith('keywords', false) ?? ''
        ])
        ->add('robots', Field::SELECT, [
            'choices' => [
                'follow' => 'Oui',
                'no-follow' => 'Non'
            ],
            'selected' => $m->seoWith('robots', false) ?? ''
        ])
        ->add('image', 'lfm', [
            'value' => $m->seoWith('image', false) ?? ''
        ]);
        $this->add('submit', 'submit', ['label' => _i('admin.create') , 'attr' => ['class' => 'btn btn-default']]);

    }
}
