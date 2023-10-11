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
use App\Adminify\Http\Controllers\Controller;

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
        public function showIndexPage(Request $request, FormBuilder $formBuilder)
        {

            $table = $this->table(TranslationTable::class);

            $views = $this->getPossiblesViews('Index');


            return $this->renderView($views, [
                'model' => (object) [],
                'table' => $table->toArray()
            ]);

            // return view("adminify::layouts.admin.pages.index", ["table" => $table]);
        }

        /**
            * Show the form for creating a new resource.
            *
            * @return Response
            */
        public function showCreatePage(FormBuilder $formBuilder)
        {
            $form = $this->makeForm(FormsCreateTranslation::class, [
                'method' => 'POST',
                'url' => route('admin.traductions.store')
            ]);

            $views = $this->getPossiblesViews('Create');

            return $this->renderView($views, [
                'model' => (object) [],
                'form' => $form->toArray()
            ]);
            //
            // return view("adminify::layouts.admin.pages.create", ['form' => $form]);
        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function handleStore(CreateTranslationRequest $request)
        {
            //
            $form = $this->makeForm(FormsCreateTranslation::class);
            $traduction = $this->translationRepository->addModel(new Traductions())->create($form);

            return $this->toJson([
                'message' => __('admin.typed_data.success'),
                'entity' => $traduction,
                'route' => 'admin.traductions.index'
            ]);
        }

        /**
            * Display the specified resource.
            *
            * @param  int  $id
            * @return Response
            */
        public function showPage($id)
        {
            //
        }

        /**
            * Show the form for editing the specified resource.
            *
            * @param  int  $id
            * @return Response
            */
        public function showEditPage(Traductions $traduction, FormBuilder $formBuilder)
        {
            // Etonnant laravel ne comprends pas l'object Traduction.

            $traduction->checkForTraduction();
            // $traduction->flashForMissing();

            $form = $this->makeForm(UpdateTranslation::class, [
                'method' => 'PUT',
                'url' => route('admin.traductions.update', ['traduction' => $traduction->id]),
                'model' => $traduction
            ]);

            $views = $this->getPossiblesViews('Edit');

            return $this->renderView($views, [
                'model' => $traduction,
                'form' => $form->toArray()
            ]);

            // return view("adminify::layouts.admin.pages.edit", ['form' => $form]);
        }

        /**
            * Update the specified resource in storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function handleUpdate(Traductions $traduction, FormBuilder $formBuilder, UpdateTranslationRequest $request)
        {
            //
            $form = $this->makeForm(UpdateTranslation::class, [
                'method' => 'PUT',
                'url' => route('admin.traductions.update', ['traduction' => $traduction->id]),
                'model' => $traduction
            ]);

            $this->translationRepository->addModel($traduction)->update($form, $traduction);

            return $this->toJson([
                'message' => __('admin.typed_data.updated'),
                'entity' => $traduction,
                'route' => 'admin.traductions.index'
            ]);
        }

        /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function handleDestroy(Traductions $traduction)
        {
            //
            $this->translationRepository->addModel($traduction)->delete($traduction);

            return $this->toJson([
                'message' => __('admin.typed_data.deleted'),
                'entity' => $traduction,
                'route' => 'admin.traductions.index'
            ]);
        }
}
