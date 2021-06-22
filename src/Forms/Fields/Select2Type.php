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
        return 'fields.select-2';
    }

    public function setDefaultsSelect2() {
        return array(
            'multiple' => true,
            'width' => '100%'
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

        $this->setOptions([
            'sibling' => Str::slug('select2_'.$uniqid),
            'withCreate' => isset($options['withCreate']) ? $options['withCreate'] : false,
            'modal' => isset($options['modal']) ? $options['modal'] : '',
            'modal_id' => Str::slug('select2_modale_'.$uniqid),
            'select2options' => array_merge($this->setDefaultsSelect2(), isset($options['select2options']) ? $options['select2options'] : [])
        ]);
        // dd($options);
        // dd($this);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
