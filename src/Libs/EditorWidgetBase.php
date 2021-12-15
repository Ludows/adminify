<?php

namespace Ludows\Adminify\Libs;

class EditorWidgetBase
{
   public function __construct() {
        $this->view = view();
        $this->request = request();
        $this->form = [];
        $this->chooseTemplate = [];
        $this->toolbar = [];
        $this->formbuilder = app('Kris\LaravelFormBuilder\FormBuilder');
        $this->showInGroups = [];
        $this->name = $this->getName();
        $this->icon = $this->getIcon();
        $this->editor = get_site_key('editor');
        $this->breakpoints_names = [];
        $this->uuid = null;
        $this->isChild = false;
        $this->config = null;
        $this->type = class_basename($this);
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
   // allow to create inetrface to choose an element to render
   public function chooseTemplate() {
      return null;
   }
   public function _setDefaultsToolbarActions() {

        if($this->isChild) {
            $this->addToolbarItem('goToParent', 'button', [

            ]);
        }
        $this->addToolbarItem('iconWidgetType', 'button', [

        ]);

        if($this->type == 'ColumnWidget') {
            $this->addToolbarItem('moreColumn', 'button', [

            ]);
            $this->addToolbarItem('deleteColumn', 'button', [

            ]);
        }

        $this->addToolbarItem('moreOptions', 'dropdown', [

        ]);

        // dropdown groups moreOptions
        $this->addToolbarItem('duplicate', 'dropdown-item', [
            'child' => 'moreOptions'
        ]);

        $this->addToolbarItem('delete', 'dropdown-item', [
            'child' => 'moreOptions'
        ]);

   }
  // public allow to add items to the toolbar
   public function toolbarRender() {
        $this->_setDefaultsToolbarActions();

   }

   public function addToolbarItem($name = '', $type = null, $options = []) {

    $isChild = isset($options['child']) && strlen($options['child']) > 0;

    $a = array(
        'type' => $type,
        'name' => $name,
        'childs' => [],
        'datas' => $this->config
    );

    if(empty($this->toolbar[$name]) && !$isChild) {
        $this->toolbar[$name] = $a;
    }
    if($isChild) {
        $this->toolbar[$options['child']]['childs'][$name] = $a;
    }

    return $this;
   }

   public function removeToolbarItem($name) {
        if(!empty($this->toolbar[$name])) {
            unset($this->toolbar[$name]);
        }
        return $this;
   }

   public function getView() {
       return 'adminify::layouts.admin.interfacable.editor.renderers.form_settings';
   }
   public function getChooseTemplateView() {
    return 'adminify::layouts.admin.interfacable.editor.renderers.choose_template';
   }
   public function getToolbarView() {
    return 'adminify::layouts.admin.interfacable.editor.renderers.toolbar';
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
        $a['data-type'] = class_basename($this);
        $a['data-visual-element'] = $this->uuid;

        $a['class'][]  = 'visual_element_block';

        if(count($this->chooseTemplate) > 0) {
            $a['class'][]  = 'd-none';
        }

        if($this->isChild) {
            $a['class'][]  = 'is-child';
        }

        if(!empty( $this->editor['defaultsCssConfigClass'][ class_basename($this) ] )) {
            $a['class'][] = $this->editor['defaultsCssConfigClass'][ class_basename($this) ];
        }

        if( $a['data-type'] == 'ColumnWidget' && $this->config['count'] > 1 ) {
            //create dynamic class column
            $column_pattern = $this->editor['patterns']['columns'];
            $col_max = $this->editor['patterns']['column_maximal'];
            $breakpoints = array_keys($this->editor['breakpoints']);

            foreach ($breakpoints as $breakpoint) {
                # code...
                $new_class_str = $column_pattern;
                $new_class_str = str_replace('##BREAKPOINT##', $breakpoint , $new_class_str);
                $new_class_str = str_replace('##WIDTH##', ( $col_max / $this->config['count'] ) , $new_class_str);

                $a['class'][] = $new_class_str;
            }




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
   public function handle() {

        $config = $this->config;
        // tell if is child block..
        $this->isChild = !empty($config['child']);

        $renderJson = [
            'uuid' => null,
            'render' => null,
            'settings' => null,
            'choose' => null,
            'toolbar' => null,
            'widgetType' => class_basename($this),
            'parent_uuid' => !empty($config['parent_uuid']) ? $config['parent_uuid'] : null,
            'isChildBlock' => $this->isChild,
            'allowChildsNesting' => $this->allowChildsNesting(),
            'haveChooseTemplate' => false
        ];


        $viewPath = $this->getView();
        $chooseTemplatePath = $this->getChooseTemplateView();
        $toolbarPath = $this->getToolbarView();

        $this->buildSettings();
        $this->chooseTemplate();
        $this->toolbarRender();

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

            if(count($this->toolbar) > 0) {
                $renderJson['toolbar'] = $this->view->make($toolbarPath, [
                    'items' => $this->toolbar,
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
   public function showInSidebar() {
       return true;
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
