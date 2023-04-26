<?php

namespace Ludows\Adminify\Http\Controllers\Back\V2;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Adminify\Forms\SeoForm;

use Illuminate\Http\Request;
use App\Adminify\Models\Seo;

use App\Adminify\Repositories\SeoRepository;
use App\Adminify\Http\Controllers\Controller;


class SeoController extends Controller
{
    use FormBuilderTrait;
    private $seoRepository;

    public function __construct(SeoRepository $seoRepository) {

        $this->seoRepository = $seoRepository;
        $this->middleware(['permission:read|edit_seo'], ['only' => ['edit', 'update']]);
    }

        /**
            * Show the form for editing the specified resource.
            *
            * @param  int  $id
            * @return Response
            */
        public function edit(Seo $seo, FormBuilder $formBuilder, Request $request, $type, $id)
        {
            // Etonnant laravel ne comprends pas l'object Traduction.

            $seo->checkForTraduction();
            // $traduction->flashForMissing();
            // $type = $request->type;
            // $id = (int) $request->id;

            if(empty($id) && empty($type)) {
                abort(403);
            }

            $model_key = adminify_get_class($type, ['app:models', 'app:adminify:models'], false);

            if(empty($model_key)) {
                abort(403);
            }

            $model = new $model_key;
            $model = $model->find($id);

            $form = $this->makeForm(SeoForm::class, [
                'method' => 'PUT',
                'url' => route('seo.update', ['type' => $type, 'id' => $id]),
                'model' => $model
            ]);

            return view("adminify::layouts.admin.pages.edit", ['form' => $form]);
        }

        /**
            * Update the specified resource in storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function update(Seo $seo, FormBuilder $formBuilder, Request $request, $type, $id)
        {
            //

            // $type = $request->type;
            // $id = (int) $request->id;

            if(empty($id) && empty($type)) {
                abort(403);
            }

            $model_key = adminify_get_class($type, ['app:models', 'app:adminify:models'], false);

            if(empty($model_key)) {
                abort(403);
            }

            $model = new $model_key;
            $model = $model->find($id);

            $form = $this->makeForm(SeoForm::class, [
                'model' => $model
            ]);

            $this->seoRepository->addModel($model)->findOrCreate($model , $form);

            return $this->sendResponseWith($model, url()->previous() , 'admin.typed_data.updated');
        }
}
