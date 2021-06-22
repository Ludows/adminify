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
    public function create($form, $request) {
        // $context is $this of the controller for more flexibility
        // dd($context, $request);
        $formValues = $form->getFieldValues();

        $file = json_decode($formValues['src']);

        $formValues['mime_type'] = $file[0]->file->type->type;

        // dirty method ?
        $formValues['src'] = $file[0]->name;

        // create entity
        $media = Media::create($formValues);

        return $media;
    }
    public function update($form, $request, $model) {

        $formValues = $form->getFieldValues();

        $file = json_decode($formValues['src']);

        $formValues['mime_type'] = $file[0]->file->type->type;

        // dirty method ?
        $formValues['src'] = $file[0]->name;


        $model->fill($formValues);
        $model->save();
    }
    public function delete($model) {
        $model->delete();
    }
}
