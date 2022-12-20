<?php 
namespace Ludows\Adminify\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;
use Illuminate\Support\Str;

class CaptchaType extends FormField {

    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'fields.captcha';
    }

    public function getDefaults() {
        return [
            'sitekey' => "{!! env('GOOGLE_RECAPTCHA') !!}",
            'theme' => 'light'
        ]
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $uniqid = Str::random(9);
        $options = array_merge($this->getOptions() , $options);

        $isAjax = request()->ajax();

        if(empty($options['sibling_attr'])) {
            $options['sibling_attr'] = [];
        }

        if(empty($options[''])) {
            $options['is_child_proto'] = false;
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
            $sibling = Str::slug('recaptcha_'. $uniqid);
            if($is_formbuilder_proto) {
                $sibling = Str::slug('recaptcha_').'-##SLOT##';
            }
        }

        if(isset($options['force_js']) && $options['force_js'] == true) {
            $isAjax = true;
        }

        $b = [
            'isAjax' => $isAjax,
            'sibling' => $sibling,
            'name' => $this->getName(),
            'recaptcha_options' => array_merge($this->getDefaults(), isset($options['recaptcha_options']) ? $options['recaptcha_options'] : [])
        ];

        $options = array_merge($options, $b);

        $options['recaptcha_id'] = Str::slug('recaptcha_field_'.$uniqid);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}