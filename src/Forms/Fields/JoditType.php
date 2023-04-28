<?php
namespace Ludows\Adminify\Forms\Fields;

use Ludows\Adminify\Libs\BaseFormField as FormField;
use Illuminate\Support\Str;

class JoditType extends FormField {

    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'adminify::fields.jodit';
    }

    public function setDefaultsOptions() {
        return array();
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $uniqid = Str::random(9);
        $options = array_merge($this->getOptions() , $options);

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
            $sibling = Str::slug('jodit_'. $uniqid);
            if($is_formbuilder_proto) {
                $sibling = Str::slug('jodit_').'-##SLOT##';
            }
        }

        if(!isset($options['jodit_options'])) {
            $options['jodit_options'] = array();
        }

        if(isset($options['force_js']) && $options['force_js'] == true) {
            $isAjax = true;
        }

        $b = [
            'isAjax' => $isAjax,
            'sibling' => $sibling,
            'jodit_options' => array_merge($this->setDefaultsOptions(), isset($options['jodit_options']) ? $options['jodit_options'] : [])
        ];

        $options = array_merge($options, $b);

        $this->setOptions($options);

        // dd($options);
        // dd($this);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
