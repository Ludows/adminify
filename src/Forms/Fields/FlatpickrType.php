<?php
namespace Ludows\Adminify\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;
use Illuminate\Support\Str;

class FlatpickrType extends FormField {

    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'adminify::fields.flatpickr';
    }

    public function setDefaultsOptions() {
        return array(

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
            $sibling = Str::slug('flatpickr_'.$uniqid);
        }

        if(isset($options['force_js']) && $options['force_js'] == true) {
            $isAjax = true;
        }


        // $getSubmit = $this->getParent()->getField('submit');
        // if(!empty($getSubmit)) {
        //     $options = $getSubmit->getOptions();
        //     if($options['attr'] && !empty($options['attr']['class'])) {
        //         $spl = explode(' ', $options['attr']['class']);
        //         // dd($spl);
        //         $spl[] = 'js-bind-repeater';

        //         $getSubmit->setOption('attr.class', join(' ', $spl));
        //     }
        // }

        $b = [
            'isAjax' => $isAjax,
            'sibling' => $sibling,
            'name' => $this->getName(),
            'flatpickr_options' => array_merge($this->setDefaultsOptions(), isset($options['flatpickr_options']) ? $options['flatpickr_options'] : [])
        ];

        $options = array_merge($options, $b);

        // $this->setOptions($options);

        // dd($options);
        // dd($this);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
