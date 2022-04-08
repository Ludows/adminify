<?php
namespace Ludows\Adminify\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;
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

    // look files to append assets.
    public function registerComponentsFolder() {
        return [
            'editor-components'
        ];
    }

    public function setDefaultsEditorAttributes() {

        $r = request();
        $isEdit = $r->isEdit;
        $array = ['type' => $r->name];

        if($isEdit) {
            $array['id'] = $r->model->id;
        }

        return array(
            'preview' => route('editor.preview', $array),
        );
    }

    public function findComponents() {

        $r = request();
        $public_ = public_path();
        $type = $r->name;

        $folders = $this->registerComponentsFolder();

        add_asset('default', config('app.url').DIRECTORY_SEPARATOR.'adminify'.DIRECTORY_SEPARATOR.'back'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'editor.js');

        foreach ($folders as $folder) {
            # code...
            $new_path = $public_.DIRECTORY_SEPARATOR.$folder;
            if(File::exists($new_path)) {
                $files = File::files($new_path);
                    foreach($files as $f){

                        $disallow_append_file = false;

                        $name = $f->getFileName();
                        $name = pathinfo($name, PATHINFO_FILENAME);
                        $check_name = explode('-', $name);



                        if(count($check_name) > 1){
                            // dd($name, $check_name, $type);

                            if($check_name[ count( $check_name ) - 1 ] != $type) {
                                $disallow_append_file = true;
                            }
                        }

                        if(!$disallow_append_file) {
                            add_asset('default', config('app.url') .DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$f->getRelativePathname());
                        }

                    }
            }

        }
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $uniqid = Str::random(9);

        $options = array_merge($this->getOptions(), $options);
        $isAjax = request()->ajax();

        if(!isset($options['visual_editor_options'])) {
            $options['visual_editor_options'] = array();
        }

        $sibling = slug('visual_editor_'.$uniqid);

        $options['attr']['id'] = 'visual_editor_id_'.$uniqid;

        $b = [
            'isAjax' => $isAjax,
            'sibling' => $sibling,
            'visual_editor_options' => array_merge($this->setDefaultsEditorAttributes(), isset($options['visual_editor_options']) ? $options['visual_editor_options'] : [])
        ];

        $options = array_merge($options, $b);

        $this->setOptions($options);

        $this->findComponents();

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
