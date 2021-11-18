<?php

namespace Ludows\Adminify\Libs;

class EditorWidgetBase
{
   public function __construct() {
        $this->view = view();
        $this->request = request();
        $this->form = [];
        $this->formbuilder = app('Kris\LaravelFormBuilder\FormBuilder');
        $this->showInGroups = [];
        $this->name = $this->getName();
        $this->icon = $this->getIcon();
   }
   public function addEditorAsset() {
       return [];
   }
   public function addFrontAsset() {
       return [];
   }
   public function handle($config) {

        $renderJson = [
            'uuid' => null,
            'render' => null,
            'settings' => null
        ];

        if(!empty($config['newWidget'])) {
            $renderJson['uuid'] = 'widget_'.uuid(20);
            $renderJson['render'] = $this->renderBlock() ?? '';
        }
        if(!empty($config['settings'])) {
            $this->renderSettings();

            if(count($this->form) > 0) {
                $renderJson['settings'] = $this->formbuilder->createByArray($this->form, [
                    'method' => 'POST',
                    'url' => '#'
                ]);
            }
        }

        return $renderJson;
   }
   public function addSettingControl($name = null, $fieldType, $fieldsOptions = []) {       
        
        if(!empty($name)) {
            $a = [
                'name' => $name,
                'type' => $fieldType
            ];

            $this->form[] = array_merge_recursive($a, $fieldsOptions);
        }
        else {}
   }
   public function renderBlock() {}
   public function renderSettings() {}
   public function getIcon() {
      return 'fa fa-clock'; // it's the sample
   }
   public function getName() {
      return 'Sample Block Name';
   }

}
