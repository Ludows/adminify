<?php
namespace Ludows\Adminify\Forms\Fields;

use Ludows\Adminify\Libs\BaseFormField as FormField;
use Illuminate\Support\Str;

use File;

class VisualEditorType extends FormField {

    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'adminify::fields.editor';
    }

    public function makeRenderableField($options = []) {
        $uniqid = Str::random(9);

        $options = array_merge($this->getOptions(), $options);
        $isAjax = request()->ajax();

        if(empty($options['is_child_proto'])) {
            $options['is_child_proto'] = false;
        }

        if(empty($options['sibling_attr'])) {
            $options['sibling_attr'] = [];
        }

        $customAttributes = $this->formHelper->prepareAttributes($options['sibling_attr']);

        if(!empty($customAttributes)) {
            $options['sibling_attr'] = $customAttributes;
        }
        else {
            $options['sibling_attr'] = [];
        }
        
        $is_formbuilder_proto = $options['is_child_proto'];

        if(!isset($options['visual_editor_options'])) {
            $options['visual_editor_options'] = array();
        }

        if(isset($options['force_sibling']) && $options['force_sibling'] == true && isset($options['sibling'])) {
            $sibling = $options['sibling'];
        }
        else {
            $sibling = Str::slug('visual_editor_'. $uniqid);
            if($is_formbuilder_proto) {
                $sibling = Str::slug('visual_editor_').'-##SLOT##';
            }
        }

        $options['visual_editor_options']['visual_element'] = 'visual-element-'. lowercase($uniqid);

        if(!$is_formbuilder_proto) {
            $options['attr']['id'] = 'visual_editor_id_'.$uniqid;
        }
        else {
            $options['attr']['id'] = 'visual_editor_id_##SLOT##';
        }

        $b = [
            'isAjax' => $isAjax,
            'sibling' => $sibling,
            'name' => $this->getName(),
            'visual_editor_options' => array_merge($this->setDefaultsEditorAttributes(), isset($options['visual_editor_options']) ? $options['visual_editor_options'] : [])
        ];

        $options = array_merge($options, $b);

        $this->setOptions($options);

        return $options;
    }

    public function setDefaultsEditorAttributes() {

        $r = request();
        $shareds = inertia()->getShared();
        $isEdit = $shareds['isEdit'];
        $array = ['type' => !empty($shareds['model']) ? class_basename($shareds['model']) : $shareds['name']];

        if($isEdit) {
            $array['id'] = $shareds['model']->id;
        }

        return array(
            'preview' => route('editor.preview', $array),
        );
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $options = $this->makeRenderableField($options);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
