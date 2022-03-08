<?php

namespace Ludows\Adminify\Repositories;

use MrAtiebatie\Repository;
use Illuminate\Support\Str;

use Ludows\Adminify\Facades\HookManagerFacade;
use App\Adminify\Models\Media;

// use Illuminate\Support\Facades\Storage;

// use App\Adminify\Repositories\AssetRepository;
// use App\Adminify\Models\Templates;

use File;


class BaseRepository
{
    use Repository;

    /**
     * The model being queried.
     *
     * @var Model
     */
    protected $model;

    // Define your internals relationship columns. The repository does'nt make treatments for this columns
    // Example You've got form_id in form trace
    public $internal_relations_columns = [];

    // Define your externals relationship columns. The repository does'nt make treatments for this columns
    // ex : tables pivot
    public $external_relations_columns = [];

    // Your can Define your Manipulation datas here
    // Example : Hash your password
    public $filters_on = [];

    // just add your ignores process data as global..
    public $ignores = [
        '_css',
        '_js',
        '_toolbars',
        '_settings_blocks'
    ];

    /**
     * Constructor
     */
    public function __construct()
    {
        // Don't forget to update the model's name
        $this->model = null;
        $this->hookManager = HookManagerFacade::getInstance();
    }
    public function addModel($class) {
        $this->model = $class;
        return $this;
    }
    protected function getNamedFunctionPattern($string_to_replace, $new_string, $string_base) {


        $strFormat = Str::remove('-', $new_string);
        $strFormat = Str::replace(' ', '', $strFormat);
        $converted = Str::camel($strFormat);

        $strFormat = Str::replace($string_to_replace, $converted, $string_base);

        return $strFormat;
    }
    protected function getProcessDb($mixed, $modelPassed = null, $hooks = [], $type = null) {
        $request = request();

        $multilang = $request->useMultilang;
        $lang = $request->lang;

        if(is_array($mixed)) {
            $formValues = $mixed;
        }
        else {
            $formValues = $mixed->getFieldValues();
        }

        $model = $modelPassed ?? $this->model;

        $fillables = $model->getFillable();

        $untouchables_relations = array_merge($this->internal_relations_columns, $this->external_relations_columns, $this->ignores);

        foreach ($fillables as $fillableKey => $fillable) {
            # code...
            $check_autoIgnore = startsWith($fillableKey, '_');
            if($check_autoIgnore) {
                $untouchables_relations[] = $fillableKey;
            }
            if(isset($formValues[$fillable])) {
                if(!in_array($fillable, $untouchables_relations)) {
                    if(method_exists($model, 'isTranslatableColumn')) {
                        $isTranslatableField = $model->isTranslatableColumn($fillable);
                    }
                    else {
                        // Support for non translateble friendly models;
                        $isTranslatableField = false;
                    }
                    if($isTranslatableField && $multilang) {
                        $model->setTranslation($fillable, $lang, $formValues[$fillable]);
                    }
                    else {
                        $model->{$fillable} = $formValues[$fillable];
                    }
                    // unset($formValues[$fillable]);
                }
            }
            else {

                $namedMethod = $this->getNamedFunctionPattern('##PLACEHOLDER##', $fillable, 'get##PLACEHOLDER##Process');

                if(method_exists($this, $namedMethod)) {
                    call_user_func_array(array($this, $namedMethod), array($model, $formValues,  $type));
                }
            }

        }

        if(method_exists($this, 'beforeRun')) {
            call_user_func_array(array($this, 'beforeRun'), array($model, $formValues,  $type));
        }

        // if($request->loadEditor && get_site_key('editor.handleAssetsGeneration') == 'before' && in_array(singular(class_basename($model)), $request->bindedEditorKeys)) {
        //     $this->handleAssetsGeneration($model, 'before');
        //     $this->createEditorSaveFile($model);
        // }

        $this->hookManager->run($hooks[0], $model);

        if(count($this->internal_relations_columns) > 0) {
            foreach ($this->internal_relations_columns as $relationable) {
                # code...

                $namedMethod = $this->getNamedFunctionPattern('##PLACEHOLDER##', $relationable, 'get##PLACEHOLDER##Relationship');

                if(method_exists($this, $namedMethod)) {
                    call_user_func_array(array($this, $namedMethod), array($model, $formValues,  $type));
                }

            }
        }

        if(count($this->filters_on) > 0) {
            foreach ($this->filters_on as $filterable) {
                $namedMethod = $this->getNamedFunctionPattern('##PLACEHOLDER##', $filterable, 'get##PLACEHOLDER##Filter');

                if(method_exists($this, $namedMethod)) {
                    call_user_func_array(array($this, $namedMethod), array($model, $formValues,  $type));
                }
            }
        }

        $model->save();

        // now the model has been created or updated. We can chain all external relationships

        if(count($this->external_relations_columns) > 0) {
            foreach ($this->external_relations_columns as $relationable) {
                # code...

                $namedMethod = $this->getNamedFunctionPattern('##PLACEHOLDER##', $relationable, 'getExternal##PLACEHOLDER##Relationship');

                if(method_exists($this, $namedMethod)) {
                    call_user_func_array(array($this, $namedMethod), array($model, $formValues,  $type));
                }

            }
        }

        $this->hookManager->run($hooks[1], $model);

        if(method_exists($this, 'afterRun')) {
            call_user_func_array(array($this, 'afterRun'), array($model, $formValues,  $type));
        }

        if($request->loadEditor && get_site_key('editor.handleAssetsGeneration') == 'after' && in_array( singular(class_basename($model)), $request->bindedEditorKeys)) {
            $this->handleAssetsGeneration($model, 'after');
            $this->createEditorSaveFile($model);
        }

        return $model;
    }
    public function getSlugProcess($model, $formValues, $type) {

        $fillable = $model->getFillable();
        if(in_array('title', $fillable)) {
            $model->slug = Str::slug($formValues['title']);
        }
        return $model;
    }

    public function getMediaIdRelationship($model, $formValues, $type) {
        if(isset($formValues['media_id']) && $formValues['media_id'] != 0) {
            $id = (int) $formValues['media_id'];

            $m = Media::where('id', $id)->first();
            if($m != null) {
                $model->media_id = $m->id;
            }
            else {
                $model->media_id = 0;
            }
        }
        // return $model;
    }

    public function create($mixed) {
        $m = $this->getProcessDb($mixed, $this->model ?? null, ['model:creating', 'model:created'], 'create');
        $this->hookManager->run('process:finished', $m);
        return $m;
    }
    public function update($mixed, $model) {
        $m = $this->getProcessDb($mixed, $this->model ?? $model, ['model:updating', 'model:updated'], 'update');
        $this->hookManager->run('process:finished', $model);
        return $m;
    }
    public function delete($model) {
        $this->hookManager->run('model:deleting', $model);
        if(method_exists($this, 'beforeRun')) {
            call_user_func_array(array($this, 'beforeRun'), array($model, [],  'destroy'));
        }

        $model->delete();

        if(method_exists($this, 'afterRun')) {
            call_user_func_array(array($this, 'afterRun'), array($model, [],  'destroy'));
        }
        $this->hookManager->run('model:deleted', $model);
        $this->hookManager->run('process:finished', $model);
        return $model;
    }
    public function handleMetas() {}
    // public function createEditorSaveFile($model = null) {
    //     $request = request();

    //     $toolbars = $request->get('_toolbars');
    //     $settingsBlocks = $request->get('_settings_blocks');
    //     $baseClass = class_basename($model);

    //     $rawContent = array(
    //         'toolbars' => $toolbars,
    //         'settingsBlocks' => $settingsBlocks
    //     );

    //     $namedFile = singular(lowercase( $baseClass )).'-'.$model->id.'.json';

    //     $fileResponse = $this->EditorFileCreator( $namedFile , json_encode($rawContent));

    // }
    // protected function EditorFileCreator($filename = null, $content = null) {
    //     $disk = $this->getEditorDisk();
    //     $typeOf = 'create';

    //     if(!$disk->exists( $filename )) {
    //         //create
    //         File::put(public_path($filename), $content);
    //     }
    //     else {
    //         //update
    //         File::delete(public_path($filename));
    //         File::put(public_path($filename), $content);

    //         $typeOf = 'update';
    //     }

    //     return [
    //         'status' => 'OK',
    //         'type' => $typeOf
    //     ];
    // }
    // protected function getEditorDisk() {
    //     $editorGlobalConfig = get_site_key('editor');
    //     $disk = Storage::disk($editorGlobalConfig['diskForSave']);
    //     return $disk;
    // }
    // public function handleAssetsGeneration($model = null, $type = 'before') {
    //     $request = request();
    //     $assetCls = adminify_get_class( 'Asset' , ['app:models', 'app:adminify:models'], false );
    //     $isCreate = true;

    //     // if($type == $editorGlobalConfig["handleAssetsGeneration"]) {
    //         $styles = $request->get('_css');
    //         $javascripts = $request->get('_js');
    //         $a = [];
    //         $b = [];
    //         $baseClass = class_basename($model);
    //         $css_strings = '';
    //         $js_strings = '';

    //         if(!empty($styles)) {

    //             $styles = json_decode($styles);
    //             $a = [
    //                 'data' => $styles
    //             ];
    //             foreach ($styles as $styleObject) {
    //                 # code...
    //                 $css_strings .= $styleObject->styles;
    //             }

    //         }

    //         if(!empty($javascripts)) {
    //             $b = [
    //                 'data' => $javascripts
    //             ];

    //             $js_strings = $javascripts;
    //         }

    //         $files = [
    //             'css' => singular(lowercase( $baseClass )).'-'.$model->id.'.css',
    //             'js' => singular(lowercase( $baseClass )).'-'.$model->id.'.js',
    //         ];

    //         foreach ($files as $namedKeyFile => $namedFile) {
    //             $assetRepo = new AssetRepository();
    //             $assetModel = new $assetCls;
    //             # code...


    //             $fileResponse = $this->EditorFileCreator( $namedFile , $namedKeyFile == 'css' ? $css_strings : $js_strings);

    //             if($fileResponse['type'] == 'update') {
    //                 $isCreate = false;
    //                 $assetModel = $model->assets()->where('type', $namedKeyFile)->get()->first();
    //             }

    //             $params_model = [
    //                 'type' => $namedKeyFile,
    //                 'model' => adminify_get_class( class_basename($model), ['app:models', 'app:adminify:models'], false ),
    //                 'entity_id' => $model->id,
    //                 'data' => json_encode( $namedKeyFile == 'css' ? $a : $b )
    //             ];

    //             if($isCreate) {
    //                 $assetRepo->addModel($assetModel)->create($params_model);
    //             }
    //             else {
    //                 $assetRepo->addModel($assetModel)->update($params_model, $assetModel);
    //             }

    //         }


    //     // }
    // }
    // public function getGeneratedFilesWithContentByEditor($id) {

    //     $this->addModel(new Templates());
    //     $m = $this->model->find($id);
    //     $ret = [
    //         'content' => '[template id="'. $id .'"]',
    //         'files' => [],
    //         'debug' => []
    //     ];

    //     if(empty($m)) {
    //         abort(404);
    //     }

    //     $baseClass = class_basename($m);

    //     $files = [
    //         'css' => singular(lowercase( $baseClass )).'-'.$m->id.'.css',
    //         'js' => singular(lowercase( $baseClass )).'-'.$m->id.'.js',
    //         'json' => singular(lowercase( $baseClass )).'-'.$m->id.'.json',
    //     ];

    //     foreach ($files as $fileKey => $file) {
    //         # code...
    //         // $ret['debug'][] = public_path() .'/'. $file;
    //         $ret['files'][$fileKey] = look_file( public_path() .'/'. $file );
    //     }

    //     return $ret;
    // }
}
