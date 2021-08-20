<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Forms\SeoForm;

use Illuminate\Http\Request;
use App\Models\Seo;

use App\Repositories\SeoRepository;
use Ludows\Adminify\Http\Controllers\Controller;


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
        public function edit(Seo $seo, FormBuilder $formBuilder, Request $request)
        {
            // Etonnant laravel ne comprends pas l'object Traduction.

            $seo->checkForTraduction();
            // $traduction->flashForMissing();
            $type = $request->get('type');
            $id = (int) $request->get('id');

            if($id == null && $type == null) {
                abort(403);
            }

            $model_key = get_site_key('register.'.$type);

            if($model_key == null) {
                abort(403);
            }

            $model = new $model_key;
            $model = $model->find($id);

            $form = $formBuilder->create(SeoForm::class, [
                'method' => 'PUT',
                'url' => route('seo.update', ['seo' => $seo->id]),
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
        public function update(Seo $seo, FormBuilder $formBuilder, Request $request)
        {
            //

            $type = $request->get('type');
            $id = (int) $request->get('id');

            if($id == null && $type == null) {
                abort(403);
            }

            $model_key = get_site_key('register.'.$type);

            if($model_key == null) {
                abort(403);
            }

            $model = new $model_key;
            $model = $model->find($id);

            $form = $this->form(SeoForm::class);

            $this->seoRepository->addModel($model)->findOrCreate($model , $form);

            if($request->ajax()) {
                return response()->json([
                    'seo' => $seo,
                    'status' => __('admin.typed_data.updated')
                ]);
            }
            else {
                flash(__('admin.typed_data.updated'))->success();
                return redirect( url()->previous() );
            }
        }
}
