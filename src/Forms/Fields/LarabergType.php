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
                'prefix' => '/admin/laravel-filemanager'
            ]
        ];
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $uniqid = Str::random(9);

        $isAjax = request()->ajax();
        
        $options = $this->getOptions();

        if(!isset($options['attr'])) {
            $options['attr'] = [];
        }
        $options['attr']['id'] = Str::slug('laraberg_textarea_'.$uniqid);

        if(isset($options['force_js']) && $options['force_js'] == true) {
            $isAjax = true;
        }

        $b = [
            'isAjax' => $isAjax,
            'attr' => [
                'id' => Str::slug('laraberg_textarea_'.$uniqid)
            ],
            'sibling' => Str::slug('laraberg_'.$uniqid),
            'fromAjax' => isset($options['fromAjax']) ? $options['fromAjax'] : false,
            'withBtnForTemplates' => isset($options['withBtnForTemplates']) ? $options['withBtnForTemplates'] : false,
            'laraberg_defaults' => array_merge($this->setDefaultsLaraberg(), isset($options['laraberg_defaults']) ? $options['laraberg_defaults'] : [])
        ];

        $options = array_merge($options, $b);  
        
        $this->setOptions($options);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
