<?php
namespace Ludows\Adminify\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;
use Illuminate\Support\Str;

class QuillEditorType extends FormField {

    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'fields.quill-editor';
    }

    public function setDefaultsQuillJs() {
        return array(
            'theme' => 'snow',
            'modules' => [
                'toolbar' => [
                    [[ 'header' => [1, 2, false] ]],
                    ['bold', 'italic', 'underline', 'align'],
                    ['link', 'image' , 'video', 'code-block']
                ]
            ],
            'placeholder' => 'Insert content...'

        );
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $uniqid = Str::random(9);

        $options = $this->getOptions();

        if(!isset($options['quill_options'])) {
            $options['quill_options'] = array();
        }

        $this->setOptions([
            'sibling' => Str::slug('quill_'.$uniqid),
            'quill_options' => array_merge($this->setDefaultsQuillJs(), $options['quill_options'])
        ]);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
