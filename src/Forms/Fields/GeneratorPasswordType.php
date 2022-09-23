<?php
namespace Ludows\Adminify\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;
use Illuminate\Support\Str;

class GeneratorPasswordType extends FormField {

    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'adminify::fields.generator-password';
    }

    public function setDefaults() {
        return array(
            'btn' => [
                'label' => __('admin.form.generate_password'),
                'attr' => ['class' => 'btn btn-default'],
            ],
        );
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $uniqid = Str::random(9);
        $options = array_merge($this->getOptions(), $options);
        $isAjax = request()->ajax();

        if(empty($options['is_child_proto'])) {
            $options['is_child_proto'] = false;
        }

        $is_formbuilder_proto = $options['is_child_proto'];

        if(isset($options['force_js']) && $options['force_js'] == true) {
            $isAjax = true;
        }

        $sibling = '';
        if(isset($options['force_sibling']) && $options['force_sibling'] == true && isset($options['sibling'])) {
            $sibling = $options['sibling'];
        }
        else {
            $sibling = Str::slug('generator_password_'. $uniqid);
            if($is_formbuilder_proto) {
                $sibling = Str::slug('generator_password_').'-##SLOT##';
            }
        }

        $b = [
            'isAjax' => $isAjax,
            'sibling' => $sibling,
            'name' => $this->getName(),
            'modal' => isset($options['modal']) ? $options['modal'] : 'adminify::layouts.admin.modales.modaleMediaLibrary',
            'generate_password_options' => array_merge($this->setDefaults(), isset($options['generate_password_options']) ? $options['generate_password_options'] : [] )
        ];


        $options = array_merge($options, $b);

        $this->setOptions($options);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
