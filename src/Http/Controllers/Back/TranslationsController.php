<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Ludows\Adminify\Forms\CreateTranslation as FormsCreateTranslation;
use Ludows\Adminify\Forms\UpdateTranslation;
use Ludows\Adminify\Forms\DeleteCrud;

use Illuminate\Http\Request;
use Ludows\Adminify\Http\Requests\CreateTranslation;
use Ludows\Adminify\Models\Translations as Traductions;

use Ludows\Adminify\Repositories\TranslationRepository;
use Ludows\Adminify\Http\Controllers\Controller;

use Ludows\Adminify\Dropdowns\Translations as TranslationDropdownManager;


class TranslationsController extends Controller
{
    use FormBuilderTrait;
    private $translationRepository;

    public function __construct(TranslationRepository $translationRepository) {

        $this->translationRepository = $translationRepository;
    }
    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        public function index(Request $request, FormBuilder $formBuilder)
        {
            $config = config('site-settings.listings');

            $model = new Traductions();
            $fillables = $model->getFillable();


            if($request->useMultilang) {
                $trans = Traductions::limit( $config['limit'] )->lang($request->lang);
                // dd($categories);
            }
            else {
                $trans = Traductions::limit( $config['limit'] )->get();
            }
            
            $a = new TranslationDropdownManager($trans ,[]);

            if(isset($trans) && count($trans) > 0) {
                $trans[0]->flashForMissing();
            }

            return view("adminify::layouts.admin.pages.index", ["datas" => $trans, 'dropdownManager' => $a, 'thead' => $fillables]);
        }

        /**
            * Show the form for creating a new resource.
            *
            * @return Response
            */
        public function create(FormBuilder $formBuilder)
        {
            $form = $formBuilder->create(FormsCreateTranslation::class, [
                'method' => 'POST',
                'url' => route('traductions.store')
            ]);
            //
            return view("adminify::layouts.admin.pages.create", ['form' => $form]);
        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function store(CreateTranslation $request)
        {
            //
            $form = $this->form(FormsCreateTranslation::class);
            $traduction = $this->translationRepository->create($form, $request);
            if($request->ajax()) {
                return response()->json([
                    'traduction' => $traduction,
                    'status' => 'La Traduction a bien été crée !'
                ]);
            }
            else {
                flash('La Traduction a bien été crée !')->success();
                return redirect()->route('traductions.index');
            }
        }

        /**
            * Display the specified resource.
            *
            * @param  int  $id
            * @return Response
            */
        public function show($id)
        {
            //
        }

        /**
            * Show the form for editing the specified resource.
            *
            * @param  int  $id
            * @return Response
            */
        public function edit(Traductions $traduction, FormBuilder $formBuilder)
        {
            // Etonnant laravel ne comprends pas l'object Traduction.

            $traduction->checkForTraduction();
            $traduction->flashForMissing();

            $form = $formBuilder->create(UpdateTranslation::class, [
                'method' => 'PUT',
                'url' => route('traductions.update', ['traduction' => $traduction->id]),
                'model' => $traduction
            ]);

            return view("adminify::layouts.admin.pages.edit", ['form' => $form]);
        }

        /**
            * Update the specified resource in storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function update(Traductions $traduction, FormBuilder $formBuilder, Request $request)
        {
            //
            $form = $this->form(UpdateTranslation::class, [
                'method' => 'PUT',
                'url' => route('traductions.update', ['traduction' => $traduction->id]),
                'model' => $traduction
            ]);

            $this->translationRepository->update($form, $request, $traduction);

            if($request->ajax()) {
                return response()->json([
                    'traduction' => $traduction,
                    'status' => 'La Traduction a bien été mise à jour !'
                ]);
            }
            else {
                flash('La Traduction a bien été mise à jour !')->success();
                return redirect()->route('traductions.index');
            }
        }

        /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function destroy(Traductions $traduction)
        {
            //
            $this->translationRepository->delete($traduction);

            // redirect
            flash('La Traduction a bien été supprimée !')->success();
            return redirect()->route('traductions.index');
        }
}
