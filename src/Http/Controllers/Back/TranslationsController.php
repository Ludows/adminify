<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Adminify\Forms\CreateTranslation as FormsCreateTranslation;
use App\Adminify\Forms\UpdateTranslation;

use Illuminate\Http\Request;
use App\Adminify\Http\Requests\CreateTranslationRequest;
use App\Adminify\Http\Requests\UpdateTranslationRequest;
use App\Adminify\Models\Translations as Traductions;

use App\Adminify\Repositories\TranslationRepository;
use Ludows\Adminify\Http\Controllers\Controller;

use Ludows\Adminify\Traits\TableManagerable;
use App\Adminify\Tables\TranslationTable;


class TranslationsController extends Controller
{
    use FormBuilderTrait;
    use TableManagerable;
    private $translationRepository;

    public function __construct(TranslationRepository $translationRepository) {

        $this->translationRepository = $translationRepository;

        $this->middleware(['permission:read|create_translations'], ['only' => ['show','create']]);
        $this->middleware(['permission:read|edit_translations'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:read|delete_translations'], ['only' => ['destroy']]);
    }
    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        public function index(Request $request, FormBuilder $formBuilder)
        {

            $table = $this->table(TranslationTable::class);

            return view("adminify::layouts.admin.pages.index", ["table" => $table]);
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
        public function store(CreateTranslationRequest $request)
        {
            //
            $form = $this->form(FormsCreateTranslation::class);
            $traduction = $this->translationRepository->addModel(new Traductions())->create($form);
            if($request->ajax()) {
                return response()->json([
                    'traduction' => $traduction,
                    'status' => __('admin.typed_data.success')
                ]);
            }
            else {
                flash(__('admin.typed_data.success'))->success();
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
            // $traduction->flashForMissing();

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
        public function update(Traductions $traduction, FormBuilder $formBuilder, UpdateTranslationRequest $request)
        {
            //
            $form = $this->form(UpdateTranslation::class, [
                'method' => 'PUT',
                'url' => route('traductions.update', ['traduction' => $traduction->id]),
                'model' => $traduction
            ]);

            $this->translationRepository->addModel($traduction)->update($form, $traduction);

            if($request->ajax()) {
                return response()->json([
                    'traduction' => $traduction,
                    'status' => __('admin.typed_data.updated')
                ]);
            }
            else {
                flash(__('admin.typed_data.updated'))->success();
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
            $this->translationRepository->addModel($traduction)->delete($traduction);

            // redirect
            flash(__('admin.typed_data.deleted'))->success();
            return redirect()->route('traductions.index');
        }
}
