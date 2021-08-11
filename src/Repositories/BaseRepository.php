<?php

namespace Ludows\Adminify\Repositories;

use MrAtiebatie\Repository;
use Illuminate\Support\Str;
use Ludows\Adminify\Libs\HookManager;


class BaseRepository
{
    use Repository;

    /**
     * The model being queried.
     *
     * @var Model
     */
    protected $model;
    private $hookManager;

    // Define our relationship columns. The repository does'nt make treatments for this columns
    public $relations_columns = [];

    /**
     * Constructor
     */
    public function __construct(HookManager $hookManager)
    {
        // Don't forget to update the model's name
        $this->model = null;
        $this->hookManager = $hookManager;
    }
    public function addModel($class) {
        $this->model = $class;
        return $this;
    }
    private function getProcessDb($mixed, $modelPassed = null, $hooks = []) {
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
            $isTranslatableField = $model->isTranslatableColumn($fillable);
            if($isTranslatableField && $multilang) {
                $model->setTranslation($fillable, $lang, $formValues[$fillable]);
            }
            else {
                $model->{$fillable} = $formValues[$fillable];
            }
            unset($formValues[$fillable]);
        }

        $this->hookManager->run('model:'.$hooks[0], $model);

        if(count($this->relations_columns) > 0) {
            foreach ($this->relations_columns as $relationable) {
                # code...

                $strFormat = Str::remove('-', $relationable);
                $strFormat = Str::remove('_', $strFormat);
                $strFormat = Str::replace(' ', '', $strFormat);
                $converted = Str::camel($strFormat);

                $namedMethod = 'get'.$converted.'Relationship';

                if(method_exists($this, $namedMethod)) {
                    call_user_func_array(array($this, $namedMethod), array($model));
                }

            }
        }

        $model->save();

        $this->hookManager->run('model:'.$hooks[1], $model);

        return $model;
    }
    public function create($mixed) {
        return $this->getProcessDb($mixed, $this->model ?? null, ['creating', 'created']);
    }
    public function update($mixed, $model) {
        return $this->getProcessDb($mixed, $this->model ?? $model, ['updating', 'updated']);
    }
    public function delete($model) {}
}
