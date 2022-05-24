<?php

namespace Ludows\Adminify\Repositories;

use MrAtiebatie\Repository;
use Illuminate\Support\Str;
use App\Adminify\Models\Media;
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

    // // Define your internals relationship columns. The repository does'nt make treatments for this columns
    // // Example You've got form_id in form trace
    // public $internal_relations_columns = [];

    // // Define your externals relationship columns. The repository does'nt make treatments for this columns
    // // ex : tables pivot
    // public $external_relations_columns = [];

    // // Your can Define your Manipulation datas here
    // // Example : Hash your password
    // public $filters_on = [];

    // just add your ignores process data as global..
    protected $ignores = ['slug'];

    /**
     * Constructor
     */
    public function __construct()
    {
        // Don't forget to update the model's name
        $this->booting();
        $this->model = null;
        $this->booted();
        $this->request = request();
        // $this->hookManager = HookManagerFacade::getInstance();
    }

    public function booting() {}
    public function booted() {}
    public function addModel($class) {
        $this->model = $class;
        return $this;
    }
    public function getIgnores() {
        return $this->ignores;
    }
    public function addIgnore($key) {
        $this->ignores[] = $key;
        return $this;
    }
    public function deleteIgnore($key) {
        unset($this->ignores[$key]);
        return $this;
    }
    // protected function getNamedFunctionPattern($string_to_replace, $new_string, $string_base) {


    //     $strFormat = Str::remove('-', $new_string);
    //     $strFormat = Str::replace(' ', '', $strFormat);
    //     $converted = Str::camel($strFormat);

    //     $strFormat = Str::replace($string_to_replace, $converted, $string_base);

    //     return $strFormat;
    // }
    protected function getProcessDb($mixed, $modelPassed = null, $type = null) {
        $request = $this->request;

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

        $untouchables_relations = $this->ignores;

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
                if(method_exists($this, 'UntriggeredModelValue')) {
                    call_user_func_array(array($this, 'UntriggeredModelValue'), array($model, $formValues,  $type));
                }
            }

        }


        $model->shouldGenerateSlug();

        if(method_exists($this, 'beforeRun')) {
            call_user_func_array(array($this, 'beforeRun'), array($model, $formValues,  $type));
        }

        // if($request->loadEditor && get_site_key('editor.handleAssetsGeneration') == 'before' && in_array(singular(class_basename($model)), $request->bindedEditorKeys)) {
        //     $this->handleAssetsGeneration($model, 'before');
        //     $this->createEditorSaveFile($model);
        // }

        // $this->hookManager->run($hooks[0], $model);

        // if(count($this->internal_relations_columns) > 0) {
        //     foreach ($this->internal_relations_columns as $relationable) {
        //         # code...

        //         $namedMethod = $this->getNamedFunctionPattern('##PLACEHOLDER##', $relationable, 'get##PLACEHOLDER##Relationship');

        //         if(method_exists($this, $namedMethod)) {
        //             call_user_func_array(array($this, $namedMethod), array($model, $formValues,  $type));
        //         }

        //     }
        // }

        // if(count($this->filters_on) > 0) {
        //     foreach ($this->filters_on as $filterable) {
        //         $namedMethod = $this->getNamedFunctionPattern('##PLACEHOLDER##', $filterable, 'get##PLACEHOLDER##Filter');

        //         if(method_exists($this, $namedMethod)) {
        //             call_user_func_array(array($this, $namedMethod), array($model, $formValues,  $type));
        //         }
        //     }
        // }

        $model->save();

        // now the model has been created or updated. We can chain all external relationships

        // if(count($this->external_relations_columns) > 0) {
        //     foreach ($this->external_relations_columns as $relationable) {
        //         # code...

        //         $namedMethod = $this->getNamedFunctionPattern('##PLACEHOLDER##', $relationable, 'getExternal##PLACEHOLDER##Relationship');

        //         if(method_exists($this, $namedMethod)) {
        //             call_user_func_array(array($this, $namedMethod), array($model, $formValues,  $type));
        //         }

        //     }
        // }

        // $this->hookManager->run($hooks[1], $model);

        if(method_exists($this, 'afterRun')) {
            call_user_func_array(array($this, 'afterRun'), array($model, $formValues,  $type));
        }

        //prevent inifinite loop
        if(get_class($model) != "App\Adminify\Models\Meta") {
            $this->handleMetas();
        }

        return $model;
    }
    // public function getSlugProcess($model, $formValues, $type) {

    //     $fillable = $model->getFillable();
    //     if(in_array('title', $fillable)) {
    //         $model->slug = Str::slug($formValues['title']);
    //     }
    //     return $model;
    // }

    // public function getMediaIdRelationship($model, $formValues, $type) {
    //     if(isset($formValues['media_id']) && $formValues['media_id'] != 0) {
    //         $id = (int) $formValues['media_id'];

    //         $m = Media::where('id', $id)->first();
    //         if($m != null) {
    //             $model->media_id = $m->id;
    //         }
    //         else {
    //             $model->media_id = 0;
    //         }
    //     }
    //     // return $model;
    // }

    public function create($mixed) {
        $m = $this->getProcessDb($mixed, $this->model ?? null, 'create');
        // $this->hookManager->run('process:finished', $m);
        return $m;
    }
    public function update($mixed, $model) {
        $m = $this->getProcessDb($mixed, $this->model ?? $model, 'update');
        // $this->hookManager->run('process:finished', $model);
        return $m;
    }
    public function delete($model) {
        // $this->hookManager->run('model:deleting', $model);
        if(method_exists($this, 'beforeRun')) {
            call_user_func_array(array($this, 'beforeRun'), array($model, [],  'destroy'));
        }

        $model->delete();

        if(method_exists($this, 'afterRun')) {
            call_user_func_array(array($this, 'afterRun'), array($model, [],  'destroy'));
        }
        // $this->hookManager->run('model:deleted', $model);
        // $this->hookManager->run('process:finished', $model);
        return $model;
    }
    public function formatMetaToSave($array = []) {

        $keys = array_keys($array);
        $a = [];

        foreach ($keys as $key) {
            # code...

            $a[] = [
                'key' => $key,
                'value' => $array[$key],
                'model_type' => get_class($this->model),
                'model_id' => $this->model->id
            ];
        }

        return $a;
    }
    public function handleMetas() {
        $request = request();

        $metaboxes = $request->get('_metaboxes');
        $metaboxModel = app('App\Adminify\Models\Meta');

        if(!empty($metaboxes)) {
            $metaboxes = explode(',', $metaboxes);

            foreach ($metaboxes as $metabox) {
                # code...
                $metabox_request = $request->get('_'.$metabox)[0];

                $values = $this->formatMetaToSave($metabox_request);

                foreach ($values as $value) {
                    # code...
                    //todo the formater for meta model.
                    $m = new $metaboxModel;
                    $m = $m->where($value);
                    $m = $m->get();

                    if($m->count() > 0) {
                        $this->addModel($m)->update($value, $m);
                    }
                    else {
                        $this->addModel(new $metaboxModel)->create($value);
                    }
                }


            }


        }
    }
}
