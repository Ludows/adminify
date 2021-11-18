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
   public function handle($config) {

        $renderJson = [
            'uuid' => null,
            'render' => null,
            'settings' => null
        ];

        if(!empty($config['newWidget'])) {
            $renderJson['uuid'] = 'widget_'.uuid(20);
            $renderJson['render'] = $this->renderBlock();
        }
        if(!empty($config['settings'])) {
            $renderJson['settings'] = $this->renderSettings();
        }

        return $renderJson;
   }
   public function addSettingControl($name, $fieldType, $fieldsOptions) {

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
