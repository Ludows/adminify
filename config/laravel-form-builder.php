<?php

return [

    'defaults' => [
        'wrapper_class'       => 'form-group',
        'wrapper_error_class' => '',
        'label_class'         => '',
        'field_class'         => 'form-control',
        'field_error_class'   => 'is-invalid',
        'help_block_class'    => 'form-text text-muted',
        'error_class'         => 'invalid-feedback',
        'required_class'      => 'required',

        'static' => [
            'field_class' => 'form-control-plaintext',
        ],

        'checkbox' => [
            'wrapper_class' => 'form-check',
            'field_class'   => 'form-check-input',
            'label_class'   => 'form-check-label',

            'choice_options' => [
                'wrapper_class' => 'custom-control custom-checkbox',
                'label_class'   => 'custom-control-label',
                'field_class'   => 'custom-control-input',
            ],
        ],

        'radio' => [
            'wrapper_class' => 'form-check',
            'field_class'   => 'form-check-input',
            'label_class'   => 'form-check-label',

            'choice_options' => [
                'wrapper_class' => 'custom-control custom-radio',
                'label_class'   => 'custom-control-label',
                'field_class'   => 'custom-control-input',
            ],
        ],

        'submit' => [
            'wrapper_class' => 'form-group',
            'field_class'   => 'btn btn-primary',
        ],

        'reset' => [
            'wrapper_class' => 'form-group',
            'field_class'   => 'btn btn-primary',
        ],
    ],

    // Templates
    'form'          => 'laravel-form-builder::form',
    'text'          => 'laravel-form-builder::text',
    'textarea'      => 'laravel-form-builder::textarea',
    'button'        => 'laravel-form-builder::button',
    'buttongroup'   => 'laravel-form-builder::buttongroup',
    'radio'         => 'laravel-form-builder::radio',
    'checkbox'      => 'laravel-form-builder::checkbox',
    'select'        => 'laravel-form-builder::select',
    'choice'        => 'laravel-form-builder::choice',
    'repeated'      => 'laravel-form-builder::repeated',
    'child_form'    => 'laravel-form-builder::child_form',
    'collection'    => 'laravel-form-builder::collection',
    'static'        => 'laravel-form-builder::static',

    // Remove the laravel-form-builder:: prefix above when using template_prefix
    'template_prefix'   => '',

    'default_namespace' => '',

    'custom_fields' => [
        //
        // 'summernote' => 'App\Adminify\Forms\Fields\SummernoteType',
        'select2' => 'App\Adminify\Forms\Fields\Select2Type',
        'generatorPassword' => 'App\Adminify\Forms\Fields\GeneratorPasswordType',
        // 'lfm' => 'App\Adminify\Forms\Fields\FileManagerType',
        "visual_editor" => 'App\Adminify\Forms\Fields\VisualEditorType',
        "tiptap" => 'App\Adminify\Forms\Fields\TipTapType',
        "media_element" => 'App\Adminify\Forms\Fields\MediaElementType',
        "jodit" => 'App\Adminify\Forms\Fields\JoditType',
        "repeater" => 'App\Adminify\Forms\Fields\RepeaterType',
        "flatpickr" => 'App\Adminify\Forms\Fields\FlatpickrType',
        "recapcha" => 'App\Adminify\Forms\Fields\CaptchaType'

    ],

];
