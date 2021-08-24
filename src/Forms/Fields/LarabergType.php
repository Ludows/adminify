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
        return 'adminify::fields.laraberg';
    }

    public function setDefaultsLaraberg() {
        return [
            'laravelFilemanager' => [
                'prefix' => '/admin/filemanager'
            ]
        ];
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $uniqid = Str::random(9);
        
        $options = $this->getOptions();

        if(!isset($options['attr'])) {
            $options['attr'] = [];
        }
        $options['attr']['id'] = Str::slug('laraberg_textarea_'.$uniqid);

        $this->setOptions([
            'attr' => [
                'id' => Str::slug('laraberg_textarea_'.$uniqid)
            ],
            'sibling' => Str::slug('laraberg_'.$uniqid),
            'withBtnForTemplates' => isset($options['withBtnForTemplates']) ? $options['withBtnForTemplates'] : false,
            'laraberg_defaults' => array_merge($this->setDefaultsLaraberg(), isset($options['laraberg_defaults']) ? $options['laraberg_defaults'] : [])
        ]);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
