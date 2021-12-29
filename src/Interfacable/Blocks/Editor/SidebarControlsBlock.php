<?php

namespace Ludows\Adminify\Interfacable\Blocks\Editor;

use Ludows\Adminify\Libs\InterfacableBlock;

class SidebarControlsBlock extends InterfacableBlock {
    public static function getNamedBlock() {
        return 'Sidebar Controls Block';
    }
    public function inject() {
        return [
            'formbuilder' => app('Kris\LaravelFormBuilder\FormBuilder')
        ];
    }
    public function addToRender() {
        $r = $this->getRequest();
        $editorConfig = get_site_key('editor');

        $method = null;
        $route = null;
        $routeParams = [];
        $model = null;

        if($r->isCreate) {
            $method = 'POST';
            $route = lowercase($r->name).'.store';
            $namedClass = $editorConfig['bind'][ titled( singular($r->name) ) ]['create'];
        }
        else {
            $method = 'PUT';
            $route = lowercase($r->name).'.edit';
            $namedClass = $editorConfig['bind'][ titled( singular($r->name) ) ]['edit'];
            $routeParams[$r->singleParam] = $r->routeParameters[ $r->singleParam ]->id;

            $model = $r->routeParameters[ $r->singleParam ];
        }

        $theClass = adminify_get_class($namedClass , ['app:forms', 'app:adminify:forms'], false);


        $form = $this->formbuilder->create($theClass, [
            'method' => $method,
            'id' => 'MainFormEditor',
            'url' => route($route, $routeParams),
            'model' => $model
        ]);

        $fields = $form->getFields();

        $form->add('_js', 'hidden', []);
        $form->add('_css', 'hidden', []);
        $form->add('_toolbars', 'hidden', []);
        $form->add('_settings_blocks', 'hidden', []);

        foreach ($fields as $fieldKey => $fieldValue) {
            # code...
            if(in_array($fieldKey, $editorConfig['implicit']['hidden_fields'])) {
                $form->modify($fieldKey, 'hidden', []);
            }
            if(in_array($fieldKey, $editorConfig['implicit']['remove_fields'])) {
                $form->remove($fieldKey);
            }
        }

        return [
            'form' => $form
        ];
    }
    public function getView() {
        return 'adminify::layouts.admin.interfacable.editor.sidebar_controls';
    }
}
