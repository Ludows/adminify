<?php
namespace Ludows\Adminify\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;
use Illuminate\Support\Str;

class LarabergType extends FormField {

    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'fields.laraberg';
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $uniqid = Str::random(9);
        $options['sibling'] = Str::slug('laraberg_'.$uniqid);
        if(!isset($options['attr'])) {
            $options['attr'] = [];
        }
        $options['attr']['id'] = Str::slug('laraberg_textarea_'.$uniqid);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
