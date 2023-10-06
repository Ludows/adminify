<?php

namespace Ludows\Adminify\Http\Controllers\Back\V2;

use App\Adminify\Models\Page;

use Illuminate\Http\Request;
use App\Adminify\Http\Controllers\Controller;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Adminify\Forms\CreateGroupMetas;
use App\Adminify\Forms\UpdateGroupMetas;

use App\Adminify\Models\GroupMeta;

use App\Adminify\Http\Requests\CreateGroupMetas as CreateGroupMetasRequest;
use App\Adminify\Http\Requests\UpdateGroupMetas as UpdateGroupMetasRequest;

use App\Adminify\Repositories\GroupMetasRepository;

use Ludows\Adminify\Traits\TableManagerable;
use App\Adminify\Tables\GroupMetasTable;
class GroupMetasController extends Controller
{
     /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        use FormBuilderTrait;
        use TableManagerable;

        private $repo;

        public function __construct(GroupMetasRepository $repo)
        {
            $this->middleware(['permission:read|create_metas'], ['only' => ['show','create']]);
            $this->middleware(['permission:read|edit_metas'], ['only' => ['edit', 'update']]);
            $this->middleware(['permission:read|delete_metas'], ['only' => ['destroy']]);
            $this->repo = $repo;
        }

        public function index(FormBuilder $formBuilder, Request $request)
        {
            $table = $this->table(GroupMetasTable::class);

            $views = $this->getPossiblesViews('Index');

            // dd($table->toArray());


            return $this->renderView($views, [
                'model' => (object) [],
                'table' => $table->toArray()
            ]);
        }

        /**
            * Show the form for creating a new resource.
            *
            * @return Response
            */
        public function create(FormBuilder $formBuilder)
        {
            $form = $this->makeForm(CreateGroupMetas::class, [
                'method' => 'POST',
                'url' => route('admin.groupmetas.store')
            ]);

            $views = $this->getPossiblesViews('Create');

            return $this->renderView($views, [
                'model' => (object) [],
                'form' => $form->toArray()
            ]);
        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function store(CreateGroupMetasRequest $request)
        {
            //
            $form = $this->makeForm(CreateGroupMetas::class);

            // dd($form->getFieldValues());

            $entity = $this->repo->addModel(new GroupMeta())->create($form);

            return $this->toJson([
                'message' => __('admin.typed_data.success'),
                'entity' => $entity,
                'route' => 'admin.groupmetas.index'
            ]);
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
        public function edit(GroupMeta $Groupmeta, FormBuilder $formBuilder, Request $request)
        {
            //
            $Groupmeta->checkForTraduction();
                $form = $this->makeForm(UpdateGroupMetas::class, [
                    'method' => 'PUT',
                    'url' => route('admin.groupmetas.update', ['groupmeta' => $Groupmeta->id]),
                    'model' => $Groupmeta
                ]);
            
            $views = $this->getPossiblesViews('Edit');

            return $this->renderView($views, [
                'model' => $Groupmeta,
                'form' => $form->toArray()
            ]);

            // $this->addJS( asset('/adminify/back/js/metas.js') );

            // return view("adminify::layouts.admin.pages.edit", ['form' => $form]);
        }

        /**
            * Update the specified resource in storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function update(UpdateGroupMetasRequest $request, GroupMeta $Groupmeta)
        {
            //
            $seo = null;
            $form = $this->makeForm(UpdateGroupMetas::class);

            $entity = $this->repo->addModel($Groupmeta)->update($form, $Groupmeta);

            return $this->toJson([
                'message' => __('admin.typed_data.updated'),
                'entity' => $entity,
                'route' => 'admin.groupmetas.index'
            ]);

            // return $this->sendResponse($entity, 'groupmetas.index', 'admin.typed_data.updated');

        }

        /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function destroy(GroupMeta $Groupmeta)
        {
            //
            $this->repo->addModel($Groupmeta)->delete($Groupmeta);

            // redirect
            // return $this->sendResponse($Groupmeta, 'groupmetas.index', 'admin.typed_data.deleted');

            return $this->toJson([
                'message' => __('admin.typed_data.deleted'),
                'entity' => $Groupmeta,
                'route' => 'admin.groupmetas.index'
            ]);
        }
}