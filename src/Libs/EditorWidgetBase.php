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
        $this->editor = get_site_key('editor');
   }
   public function addEditorAsset() {
       return [];
   }
   public function addFrontAsset() {
       return [];
   }
   public function getView() {
       return null;
   }
   public function allowChildsNesting() {
       return true;
   }
   public function categories() {
       return [];
   }
   public function injectBlocks() {
        return [];
   }
   public function getDescription() {
       return '';
   }
   public function handle($config) {

        $renderJson = [
            'uuid' => null,
            'render' => null,
            'settings' => null,
            'allowChildsNesting' => $this->allowChildsNesting()
        ];

        $viewPath = $this->getView();

        if(!empty($config['newWidget'])) {
            $renderJson['uuid'] = 'widget_'.uuid(20);
            $renderJson['render'] = $this->renderBlock($renderJson['uuid']) ?? '';
        }
        if(!empty($config['settings'])) {
            $this->addSettingControl('widget_type', 'hidden', [
                'value' => $this->request->route()->parameter('widget'),
            ]);

            if(!empty($config['newWidget'])) {
                $this->addSettingControl('widget_uuid', 'hidden', [
                    'value' => $renderJson['uuid'],
                ]);
            }

            $this->buildSettings();

            if(count($this->form) > 0) {
                $renderJson['settings'] = $this->formbuilder->createByArray($this->form, [
                    'method' => 'POST',
                    'class' => 'form_setting',
                    'id' => 'form_setting_'.$renderJson['uuid'],
                    'url' => '#'
                ]);

                if(empty($viewPath)) {
                    $renderJson['settings'] = form($renderJson['settings']);
                }
                else {
                    $renderJson['settings'] = $this->view->make($viewPath, [
                        'form' => $renderJson['settings'],
                        'editor' => $this->editor,
                        'uuid' => $renderJson['uuid']
                    ])->render();
                }
            }
        }

        return $renderJson;
   }
   public function addSettingControl($name = null, $fieldType = null, $fieldsOptions = []) {

        if(!empty($name)) {
            $a = [
                'name' => $name,
                'type' => $fieldType
            ];

            $this->form[] = array_merge_recursive($a, $fieldsOptions);
        }
        else {}
   }
   public function addSettingControlWithBreakpoints($name = null, $fieldType = null, $fieldsOptions = []) {

        $breakpoints = $this->editor['breakpoints'];
        if(!empty($name)) {

            $this->addSettingControl($name, $fieldType, $fieldsOptions);

            foreach ($breakpoints as $breakpointKey => $breakpointValue) {
                # code...
                $a = [
                    'name' => $name.'_'.$breakpointKey,
                    'type' => $fieldType,
                    'attr' => [
                        'data-settings-breakpoint' => $breakpointKey
                    ]
                ];

                $this->form[] = array_merge_recursive($a, $fieldsOptions);
            }

        }
        else {}

   }
   public function renderBlock($uuid) {}
   public function buildSettings() {}
   public function getIcon() {
      return 'fa fa-clock'; // it's the sample
   }
   public function getName() {
      return 'Sample Block Name';
   }

}
