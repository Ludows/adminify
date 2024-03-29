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

        $options = array_merge($this->getOptions(), $options);
        $isAjax = request()->ajax();

        if(empty($options['is_child_proto'])) {
            $options['is_child_proto'] = false;
        }

        if(empty($options['sibling_attr'])) {
            $options['sibling_attr'] = [];
        }

        $customAttributes = $this->formHelper->prepareAttributes($options['sibling_attr']);

        if(!empty($customAttributes)) {
            $options['sibling_attr'] = $customAttributes;
        }
        else {
            $options['sibling_attr'] = '';
        }

        $is_formbuilder_proto = $options['is_child_proto'];

        $sibling = '';
        if(isset($options['force_sibling']) && $options['force_sibling'] == true && isset($options['sibling'])) {
            $sibling = $options['sibling'];
        }
        else {
            $sibling = Str::slug('select2_'. $uniqid);
            if($is_formbuilder_proto) {
                $sibling = Str::slug('select2_').'-##SLOT##';
            }
        }

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

        if(isset($options['force_js']) && $options['force_js'] == true) {
            $isAjax = true;
        }

        $options['modal_attributes']['id'] = Str::slug('select2_modale_'.$uniqid);

        $b = [
            'isAjax' => $isAjax,
            'sibling' => $sibling,
            'name' => $this->getName(),
            'withCreate' => isset($options['withCreate']) ? $options['withCreate'] : false,
            'dynamic_modal' => isset($options['dynamic_modal']) ? $options['dynamic_modal'] : true,
            'form' => [
                'namespace' => isset($options['form']['namespace']) ? $options['form']['namespace'] : null,
                'attributes' => isset($options['form']['attributes']) ? $options['form']['attributes'] : []
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
