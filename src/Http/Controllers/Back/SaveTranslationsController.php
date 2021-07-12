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

        public function update(FormBuilder $formBuilder, Request $request)
        {
            //
            $all = $request->all();
            dd($all);

            // $this->translationRepository->update($form, $request, $traduction);

            // if($request->ajax()) {
            //     return response()->json([
            //         'traduction' => $traduction,
            //         'status' => 'La Traduction a bien été mise à jour !'
            //     ]);
            // }
            // else {
            //     flash('La Traduction a bien été mise à jour !')->success();
            //     return redirect()->route('traductions.index');
            // }
        }
}