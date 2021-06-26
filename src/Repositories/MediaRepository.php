<?php

namespace Ludows\Adminify\Repositories;

use MrAtiebatie\Repository;
use Ludows\Adminify\Models\Media; // Don't forget to update the model's namespace
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;



class MediaRepository
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
        $this->model = app(Media::class);
    }
    public function create($mixed, $request) {
        // $context is $this of the controller for more flexibility
        // dd($context, $request);
        if(is_array($mixed)) {
            $formValues = $mixed;
        }
        else {
            $formValues = $mixed->getFieldValues();
        }

        if(is_string($formValues['src']) && !str_starts_with($formValues['src'], '[{')) {
            $pathinfo = pathinfo($formValues['src']);
            $formValues['mime_type'] = $pathinfo['extension'];
        }
        else {
            $file = json_decode($formValues['src']);

            $formValues['mime_type'] = $file[0]->file->type->type;

            // dirty method ?
            $formValues['src'] = $file[0]->name;
        }
        

        // create entity
        $media = Media::create($formValues);

        return $media;
    }
    public function update($mixed, $request, $model) {

        if(is_array($mixed)) {
            $formValues = $mixed;
        }
        else {
            $formValues = $mixed->getFieldValues();
        }

        if(is_string($formValues['src']) && !str_starts_with($formValues['src'], '[{')) {
            $pathinfo = pathinfo($formValues['src'], PATHINFO_EXTENSION);
            $formValues['mime_type'] = $pathinfo['extension'];
        }
        else {
            $file = json_decode($formValues['src']);

            $formValues['mime_type'] = $file[0]->file->type->type;

            // dirty method ?
            $formValues['src'] = $file[0]->name;
        }

        $model->fill($formValues);
        $model->save();
    }
    public function delete($model) {
        $model->delete();
    }
}
