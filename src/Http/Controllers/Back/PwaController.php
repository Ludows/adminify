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
    public function index(Pwa $pwa, FormBuilder $formBuilder, Request $request)
        {

            $form = $this->makeForm(CreatePwa::class, [
                'method' => 'POST',
                'url' => route('pwa.store'),
            ]);

            return view("adminify::layouts.admin.pages.index", ['form' => $form]);
        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function store(SavePwa $request)
        {
            //
            $form = $this->makeForm(CreatePwa::class);
            $pwa = $this->PwaRepository->CreateOrUpdate($form);
            // @todo process manifest

            return $this->sendResponse($pwa, 'pwa.index', 'admin.typed_data.success');
        }
}
