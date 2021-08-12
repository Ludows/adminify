<?php

namespace Ludows\Adminify\Repositories;

use MrAtiebatie\Repository;
use Illuminate\Support\Str;

use Ludows\Adminify\Facades\HookManagerFacade;
use App\Models\Media;

class BaseRepository
{
    use Repository;

    /**
     * The model being queried.
     *
     * @var Model
     */
    protected $model;

    // Define our relationship columns. The repository does'nt make treatments for this columns
    public $relations_columns = [];

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
    private function getProcessDb($mixed, $modelPassed = null, $hooks = [], $type = null) {
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

        foreach ($fillables as $fillable) {
            # code...
            if(isset($formValues[$fillable])) {
                if(!in_array($fillable, $this->relations_columns)) {
                    $isTranslatableField = $model->isTranslatableColumn($fillable);
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
                $strFormat = Str::remove('-', $fillable);
                $strFormat = Str::remove('_', $strFormat);
                $strFormat = Str::replace(' ', '', $strFormat);
                $converted = Str::camel($strFormat);

                $namedMethod = 'get'.Str::ucfirst($converted).'Process';

                if(method_exists($this, $namedMethod)) {
                    call_user_func_array(array($this, $namedMethod), array($model, $formValues,  $type));
                }
            }
            
        }

        $this->hookManager->run('model:'.$hooks[0], $model);

        if(count($this->relations_columns) > 0) {
            foreach ($this->relations_columns as $relationable) {
                # code...

                $strFormat = Str::remove('-', $relationable);
                $strFormat = Str::remove('_', $strFormat);
                $strFormat = Str::replace(' ', '', $strFormat);
                $converted = Str::camel($strFormat);

                $namedMethod = 'get'.Str::ucfirst($converted).'Relationship';

                if(method_exists($this, $namedMethod)) {
                    call_user_func_array(array($this, $namedMethod), array($model, $formValues,  $type));
                }

            }
        }

        $model->save();

        $this->hookManager->run('model:'.$hooks[1], $model);

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
            $json = json_decode($formValues['media_id']);
        
            $m = Media::where('src', $json[0]->name)->first();
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
        return $this->getProcessDb($mixed, $this->model ?? null, ['creating', 'created'], 'create');
    }
    public function update($mixed, $model) {
        return $this->getProcessDb($mixed, $this->model ?? $model, ['updating', 'updated'], 'update');
    }
    public function delete($model) {}
}
