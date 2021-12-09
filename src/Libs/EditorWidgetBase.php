<?php

namespace Ludows\Adminify\Libs;

class EditorWidgetBase
{
   const COLUMN_MINIMAL = 1;
   const COLUMN_MAXIMAL = 12;
   public function __construct() {
        $this->view = view();
        $this->request = request();
        $this->form = [];
        $this->chooseTemplate = [];
        $this->formbuilder = app('Kris\LaravelFormBuilder\FormBuilder');
        $this->showInGroups = [];
        $this->name = $this->getName();
        $this->icon = $this->getIcon();
        $this->editor = get_site_key('editor');
        $this->breakpoints_names = [];
        $this->uuid = null;
        $injector = $this->addChildsBlocks();

        if(!empty($injector)) {
            $this->childs = [];
            foreach ($injector as $namedClass) {
                # code...
                $this->childs[$namedClass] = adminify_get_class($namedClass, ['app:widgets', 'app:adminify:widgets'], false);
            }
        }
   }
   public function addEditorAsset() {
       return [];
   }
   public function addFrontAsset() {
       return [];
   }
   public function getNestableHtml() {

        $str = '';
        if($this->allowChildsNesting()) {
            $str = '<div data-uuid="'. $this->uuid .'" class="nesting_sortable"></div>';
        }

       return $str;
   }
   // allow to create inetrface to choose an element to render
   public function chooseTemplate() {
        return null;
   }
   public function getView() {
       return 'adminify::layouts.admin.interfacable.editor.renderers.form_settings';
   }
   public function getChooseTemplateView() {
    return 'adminify::layouts.admin.interfacable.editor.renderers.choose_template';
   }
   public function allowChildsNesting() {
       return true;
   }
   public function categories() {
       return [];
   }
   public function addChildsBlocks() {
       return [];
   }
   public function getDescription() {
       return '';
   }
   public function allowContentEdition() {
       return true;
   }
   public function renderAttributes() {
        $a = [
            'class' => []
        ];
        if(!empty($this->uuid)) {
            $a['class'][] = $this->uuid;
        }
        if(!empty( $this->editor['defaultsCssConfigClass'][ class_basename($this) ] )) {
            $a['class'][] = $this->editor['defaultsCssConfigClass'][ class_basename($this) ];
        }
        if($this->allowContentEdition()) {
            $a['contenteditable'] = 'true';
        }

        // start rendering attributes
        $str = '';
        foreach ($a as $attribKey => $attribValue) {
            # code...

            if(is_array($attribValue)) {
                $attribValue = join(' ', $attribValue);
            }


            $str .= ''. $attribKey .'="'. $attribValue .'" ';
        }

        return $str;
   }
   public function getGlobalsControlFields() {
        $a = [];
        $fields = $this->formObject->getFields();
        if(count($this->form) > 0) {
            foreach ($fields as $field) {
                # code...
                $name = $field->getName();
                if( !in_array( $name , $this->breakpoints_names) ) {
                    $a[ $name ] = $field;
                }
            }
        }
        return $a;
   }
   public function getBreakpointsControlFields() {
        $a = [];
        $fields = $this->formObject->getFields();
        if(count($this->form) > 0) {
            foreach ($fields as $field) {
                # code...
                $name = $field->getName();
                if( in_array( $name , $this->breakpoints_names) ) {
                    $a[ $name ] = $field;
                }
            }
        }
        return $a;
   }
   public function getBreakpointsControlFieldsByTypes() {
        $fields = $this->getBreakpointsControlFields();
        $breakpoints = array_keys($this->editor['breakpoints']);
        $returnArray = [];

        // format default array
        foreach ( $breakpoints as  $breakpoint) {
            # code...
            $returnArray[ $breakpoint ] = [];
        }

        foreach ($fields as $field) {
            # code...

            $name = $field->getName();

            foreach ( $breakpoints as  $breakpoint) {
                if(endsWith($name, '_'.$breakpoint)) {
                    $returnArray[$breakpoint][] = $field;
                }
            }
        }


        return $returnArray;
   }
   public function handle($config) {

        $renderJson = [
            'uuid' => null,
            'render' => null,
            'settings' => null,
            'choose' => null,
            'isChildBlock' => !empty($config['child']) ? $config['child'] : false,
            'allowChildsNesting' => $this->allowChildsNesting(),
            'haveChooseTemplate' => false
        ];

        $viewPath = $this->getView();
        $chooseTemplatePath = $this->getChooseTemplateView();

        if(!empty($config['newWidget'])) {
            $this->uuid = 'widget_'.uuid(20);
            $renderJson['uuid'] = $this->uuid;
            $renderJson['render'] = $this->renderBlock() ?? '';
        }
        if(!empty($config['settings'])) {
            $this->addSettingControl('widget_type', 'hidden', [
                'value' => $this->request->route()->parameter('widget'),
            ]);

            if(!empty($config['newWidget'])) {
                $this->addSettingControl('widget_uuid', 'hidden', [
                    'value' => $this->uuid,
                ]);
            }

            $this->buildSettings();
            $this->chooseTemplate();

            if(count($this->chooseTemplate) > 0) {

                $renderJson['haveChooseTemplate'] = true;

                $this->addChoose('widget_type', 'hidden', [
                    'value' => $this->request->route()->parameter('widget'),
                ]);

                $this->addChoose('widget_uuid', 'hidden', [
                    'value' => $this->uuid,
                ]);

                $chooserForm = $this->formbuilder->createByArray($this->chooseTemplate, [
                    'method' => 'POST',
                    'class' => 'form_choose row no-gutters',
                    'id' => 'form_choose_'.$this->uuid,
                    'url' => '#'
                ]);


                $renderJson['choose'] = $this->view->make($chooseTemplatePath, [
                    'form' => $chooserForm,
                    'editor' => $this->editor,
                    'uuid' => $this->uuid,
                    'breakpoints_names' => $this->breakpoints_names
                ])->render();
            }

            if(count($this->form) > 0) {
                $renderJson['settings'] = $this->formbuilder->createByArray($this->form, [
                    'method' => 'POST',
                    'class' => 'form_setting',
                    'id' => 'form_setting_'.$this->uuid,
                    'url' => '#'
                ]);

                $this->formObject = $renderJson['settings'];

                $globalsFields = $this->getGlobalsControlFields();
                $breakpointsFields = $this->getBreakpointsControlFieldsByTypes();

                $renderJson['settings'] = $this->view->make($viewPath, [
                    'form' => $renderJson['settings'],
                    'global_controls' => $globalsFields,
                    'breakpoints_controls' => $breakpointsFields,
                    'editor' => $this->editor,
                    'uuid' => $this->uuid,
                    'breakpoints_names' => $this->breakpoints_names
                ])->render();
            }
        }

        if(!empty($chooser)) {

        }

        return $renderJson;
   }
   public function addChoose($name = null, $fieldType = null, $fieldsOptions = []) {
        if(!empty($name)) {
            $a = [
                'name' => $name,
                'type' => $fieldType,
                'attr' => [
                    'data-editor-choose' => $name,
                ],
                'label' => __('admin.editor.choose.'.$name)
            ];

            $this->chooseTemplate[] = array_merge_recursive($a, $fieldsOptions);
        }
        else {}
   }
   public function addSettingControl($name = null, $fieldType = null, $fieldsOptions = []) {

        if(!empty($name)) {
            $a = [
                'name' => $name,
                'type' => $fieldType,
                'attr' => [
                    'data-editor-track' => $name,
                ],
                'label' => __('admin.editor.'.$name)
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
                        'data-settings-breakpoint' => $breakpointKey,
                        'data-editor-track' => $name.'_'.$breakpointKey
                    ],
                    'label' => __('admin.editor.'.$name.'_'.$breakpointKey)
                ];

                $this->breakpoints_names[] = $name.'_'.$breakpointKey;
                $this->form[] = array_merge_recursive($a, $fieldsOptions);
            }

        }
        else {}

   }
   public function renderBlock() {}
   public function buildSettings() {}
   public function getIcon() {
      return 'fa fa-clock'; // it's the sample
   }
   public function getName() {
      return 'Sample Block Name';
   }

}
