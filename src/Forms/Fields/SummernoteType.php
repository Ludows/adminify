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

        $options = $this->getOptions();

        if(!isset($options['summernote_options'])) {
            $options['summernote_options'] = array();
        }

        $this->setOptions([
            'sibling' => Str::slug('summernote_'.$uniqid),
            'summernote_options' => array_merge($this->setDefaultsSummernoteOptions(), isset($options['summernote_options']) ? $options['summernote_options'] : [])
        ]);
        // dd($options);
        // dd($this);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
