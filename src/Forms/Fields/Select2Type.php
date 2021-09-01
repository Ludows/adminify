<?php
namespace Ludows\Adminify\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;
use Illuminate\Support\Str;

class Select2Type extends FormField {

    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'adminify::fields.select-2';
    }

    public function setDefaultsSelect2() {
        return array(
            'multiple' => true,
            'width' => '100%'
        );
    }

    public function setDefaultModalAttributes() {
        return array(
            'classes' => '',
            'modalBodyClass' => '',
            'modalDialogClasses' => '',
            'modalTitle' => '',
            'btnSave' => '',
            'btnClear' => ''
        );
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $uniqid = Str::random(9);

        $options = $this->getOptions();

        if(!isset($options['select2options'])) {
            $options['select2options'] = array();
        }

        if(!isset($options['selected'])) {
            $options['selected'] = '';
        }

        $options['attr']['id'] = 'select2_id_'.$uniqid;

        if(!isset($options['empty_value'])) {
            $options['empty_value'] = '';
        }

        if(!isset($options['choices'])) {
            $options['choices'] = [];
        }

        if(!isset($options['form'])) {
            $options['form'] = [];
        }

        if(!isset($options['modal_attributes'])) {
            $options['modal_attributes'] = [];
        }

        $options['modal_attributes']['id'] = Str::slug('select2_modale_'.$uniqid);

        $b = [
            'sibling' => Str::slug('select2_'.$uniqid),
            'withCreate' => isset($options['withCreate']) ? $options['withCreate'] : false,
            'dynamic_modal' => isset($options['dynamic_modal']) ? $options['dynamic_modal'] : true,
            'form' => [
                'namespace' => isset($options['linked_form_namespace']) ? $options['form']['linked_form_namespace'] : null,
                'attributes' => isset($options['attributes_form']) ? $options['form']['attributes_form'] : []
            ],
            'modal_attributes' => array_merge($this->setDefaultModalAttributes(), $options['modal_attributes']),
            'modal' => isset($options['modal']) ? $options['modal'] : '',
            'select2options' => array_merge($this->setDefaultsSelect2(), isset($options['select2options']) ? $options['select2options'] : [])
        ];

        $options = array_merge($options, $b);

        $this->setOptions($options);
        // dump($options);
        // dd($options);
        // dd($this);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
