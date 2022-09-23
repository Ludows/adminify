<?php
namespace Ludows\Adminify\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;
use Illuminate\Support\Str;

class SummernoteType extends FormField {

    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'adminify::fields.summernote';
    }

    public function setDefaultsSummernoteOptions() {
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

        $is_formbuilder_proto = $options['is_child_proto'];

        $sibling = '';
        if(isset($options['force_sibling']) && $options['force_sibling'] == true && isset($options['sibling'])) {
            $sibling = $options['sibling'];
        }
        else {
            $sibling = Str::slug('summernote_'. $uniqid);
            if($is_formbuilder_proto) {
                $sibling = Str::slug('summernote_').'-##SLOT##';
            }
        }



        if(!isset($options['summernote_options'])) {
            $options['summernote_options'] = array();
        }

        if(isset($options['force_js']) && $options['force_js'] == true) {
            $isAjax = true;
        }

        $b = [
            'isAjax' => $isAjax,
            'sibling' => $sibling,
            'summernote_options' => array_merge($this->setDefaultsSummernoteOptions(), isset($options['summernote_options']) ? $options['summernote_options'] : [])
        ];

        $options = array_merge($options, $b);

        $this->setOptions($options);

        // dd($options);
        // dd($this);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
