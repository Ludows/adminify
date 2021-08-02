<?php

namespace Ludows\Adminify\Repositories;

use MrAtiebatie\Repository;
use App\Models\Templates; // Don't forget to update the model's namespace


class TemplatesRepository
{
    use Repository;

    /**
     * The model being queried.
     *
     * @var Model
     */
    protected $model;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Don't forget to update the model's name
        $this->model = app(Templates::class);
    }
    public function create($mixed, $request) {

        if(is_array($mixed)) {
            $formValues = $mixed;
        }
        else {
            $formValues = $mixed->getFieldValues();
        }

        $template = new Templates();

        $template = $template->create($formValues);

        return $template;
    }
    public function update($mixed, $request, $model) {

        if(is_array($mixed)) {
            $formValues = $mixed;
        }
        else {
            $formValues = $mixed->getFieldValues();
        }

        $model = $model->fill($formValues);
        $model::booted();

        return $model;
    }
    public function delete($model) {
        $model->delete();
    }
}
