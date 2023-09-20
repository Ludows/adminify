<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
use Kris\LaravelFormBuilder\Field;

class CreateUser extends BaseForm
{
    public function buildForm()
    {
        // Add fields here...

        $rDatas = $this->getRoles();
        $enabled_features = $this->getFeaturesSite();

        $this
            ->add('name', Field::TEXT, [
                'label' => __('admin.form.name'),
            ]);
            if(isset($enabled_features['media']) && $enabled_features['media']) { 
                $this->add('avatar', 'media_element', [
                    'label' => __('admin.form.avatar'),
                ]);
            }
            $this->add('email', Field::EMAIL, [
                'label' => __('admin.form.email'),
            ]);

            $this->addRoles('roles', [
                'empty_value' => '',
                'attr' => [],
                'label' => __('admin.form.select_entity', ['entity' => 'role']),
                'label_attr' => ['class' => 'control-label', 'for' => 'roles'],
                'select2options' => [
                    'placeholder' => __('admin.form.select_entity', ['entity' => 'role']),
                    'multiple' => false,
                    'width' => '100%'
                ]
            ])
            ->add('password', 'generatorPassword', [
                'label' => __('admin.form.password'),
            ]);

            $this->addSubmit();
    }
}
