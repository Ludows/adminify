<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Adminify\Forms\CreatePwa;

use App\Adminify\Http\Requests\SavePwa;
use App\Adminify\Repositories\PwaRepository;
use App\Adminify\Models\Pwa;
use App\Adminify\Http\Controllers\Controller;


class PwaController extends Controller
{
    use FormBuilderTrait;
    public function __construct(PwaRepository $PwaRepository) {

        $this->PwaRepository = $PwaRepository;

        $this->middleware(['permission:read|create_settings'], ['only' => ['show','create']]);
        $this->middleware(['permission:read|edit_settings'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:read|delete_settings'], ['only' => ['destroy']]);
    }
    public function showIndexPage(Pwa $pwa, FormBuilder $formBuilder, Request $request)
        {

            $form = $this->makeForm(CreatePwa::class, [
                'method' => 'POST',
                'url' => route('admin.pwa.store'),
            ]);


            return $this->renderView('Index', [
                'model' => (object) [],
                'form' => $form->toArray()
            ]);

        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function handleStore(SavePwa $request)
        {
            //
            $form = $this->makeForm(CreatePwa::class);
            $pwa = $this->PwaRepository->CreateOrUpdate($form);

            return $this->toJson([
                'message' => __('admin.typed_data.success'),
                'entity' => $pwa,
                'route' => 'admin.pwa.index'
            ]);

            // return $this->sendResponse($pwa, 'pwa.index', 'admin.typed_data.success');
        }
}
