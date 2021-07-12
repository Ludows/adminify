<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Forms\SaveMissingTraductions;

use App\Repositories\SaveTranslationRepository;


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
            public function edit(Traductions $traduction, FormBuilder $formBuilder)
            {
                
    
                $form = $formBuilder->create(SaveMissingTraductions::class, [
                    'method' => 'PUT',
                    'url' => route('savetraductions.update', ['savetraduction' => $traduction->id]),
                    'model' => $traduction
                ]);
    
                return view("adminify::layouts.admin.pages.edit", ['form' => $form]);
            }

        public function update(Traductions $traduction, FormBuilder $formBuilder, Request $request)
        {
            //
            // $form = $this->form(SaveMissingTraductions::class, [
            //     'method' => 'PUT',
            //     'url' => route('traductions.update', ['traduction' => $traduction->id]),
            //     'model' => $traduction
            // ]);

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
