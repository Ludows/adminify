<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Forms\SaveMissingTraductions;

use App\Repositories\SaveTranslationRepository;
use Illuminate\Http\Request;



use Ludows\Adminify\Http\Controllers\Controller;
class SaveTranslationsController extends Controller
{
    use FormBuilderTrait;
    private $translationRepository;

    public function __construct(SaveTranslationRepository $translationRepository) {

        $this->translationRepository = $translationRepository;
    }
    /**
            * Show the form for editing the specified resource.
            *
            * @param  int  $id
            * @return Response
            */
            public function edit(FormBuilder $formBuilder , Request $request)
            {

                $type = $request->get('type');
                $originLang = $request->get('from');
                $actualLang = $request->get('lang');

                if($type == null && $originLang == null && $actualLang == null) {
                    abort(403);
                }

                $config = config('site-settings');
                $id = \Route::current()->parameter($request->singleParam);

                $model = new $config['savetraductions'][$type]['model']();


                $clsForm = $this->form($config['savetraductions'][$type]['clsForm']);

                $form = $formBuilder->create(SaveMissingTraductions::class, [
                    'method' => 'PUT',
                    'url' => route('savetraductions.update', ['savetraduction' => $id]),
                ], [
                    'id' => $id,
                    'type' => $type,
                    'clsForm' => $clsForm,
                    'fromLang' => $originLang,
                    'actualLang' => $actualLang,
                    'config' => $config['savetraductions'][$type],
                    'model' => $model->find($id)
                ]);

                return view("adminify::layouts.admin.pages.edit", ['form' => $form]);
            }

        public function update(Request $request)
        {
            //
            $all = $request->all();
            //dd($all);

            $config = config('site-settings');
            $model = new $config['savetraductions'][$all['type']]['model']();
            $model = $model->find($all['id']);

            $excludes = [
                '_method',
                '_token',
                'from',
                'current_lang',
                'type',
                'id'
            ];

            $sanitized =  $all;
            foreach ($sanitized as $key => $value) {
                # code...
                if(in_array($key, $excludes)) {
                    unset($sanitized[$key]);
                }
            }
            //dd($sanitized);

            if(array_key_exists('title', $sanitized)) {
                $model->setTranslation('slug', $all['current_lang'], Str::slug($sanitized['title']));
            }

            foreach ($sanitized as $sanitizedKey => $value) {
                # code...
                $model->setTranslation($sanitizedKey, $all['current_lang'], $value);
            }

            $model::booted();
            $model->save();

            // $this->translationRepository->update($form, $request, $traduction);

            if($request->ajax()) {
                return response()->json([
                    'translation' => $model,
                    'status' => 'La Translation a bien été faite !'
                ]);
            }
            else {
                flash('La Translation a bien été faite !')->success();
                return redirect(url()->previous());
            }
        }
}
