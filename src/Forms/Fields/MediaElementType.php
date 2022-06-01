<?php
namespace Ludows\Adminify\Forms\Fields;

use Closure;
use Kris\LaravelFormBuilder\Fields\FormField;
use Illuminate\Support\Str;

class MediaElementType extends FormField {

    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'adminify::fields.media_element';
    }

    public function setDefaultsOptions() {
        return array(
            'media' => null,
            'multiple' => false,
            'btn' => [
                'label' => __('admin.form.select_media'),
                'attr' => ['class' => 'btn btn-default'],
            ]
        );
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $uniqid = Str::random(9);
        $options = array_merge($this->getOptions() , $options);

        $isAjax = request()->ajax();

        $sibling = '';
        if(isset($options['force_sibling']) && $options['force_sibling'] == true && isset($options['sibling'])) {
            $sibling = $options['sibling'];
        }
        else {
            $sibling = Str::slug('media_element_'.$uniqid);
        }

        if(!isset($options['media_element_options'])) {
            $options['media_element_options'] = array();
        }

        if(isset($options['force_js']) && $options['force_js'] == true) {
            $isAjax = true;
        }

        $b = [
            'isAjax' => $isAjax,
            'sibling' => $sibling,
            'media_element_options' => array_merge($this->setDefaultsOptions(), isset($options['media_element_options']) ? $options['media_element_options'] : [])
        ];

        $options = array_merge($options, $b);

        $this->setOptions($options);

        // dd($options);
        // dd($this);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
