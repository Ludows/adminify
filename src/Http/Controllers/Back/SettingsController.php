<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Adminify\Forms\CreateSettings;

use App\Adminify\Http\Requests\SaveSettings;
use App\Adminify\Repositories\SettingsRepository;
use App\Adminify\Models\Settings;
use Ludows\Adminify\Http\Controllers\Controller;


class SettingsController extends Controller
{
    use FormBuilderTrait;
    public function __construct(SettingsRepository $settingsRepository) {

        $this->settingsRepository = $settingsRepository;

        $this->middleware(['permission:read|create_settings'], ['only' => ['show','create']]);
        $this->middleware(['permission:read|edit_settings'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:read|delete_settings'], ['only' => ['destroy']]);
    }
    public function index(Settings $settings, FormBuilder $formBuilder, Request $request)
        {

            $form = $formBuilder->create(CreateSettings::class, [
                'method' => 'POST',
                'url' => route('settings.store'),
            ]);

            return view("adminify::layouts.admin.pages.index", ['form' => $form]);
        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function store(SaveSettings $request)
        {
            //
            $form = $this->form(CreateSettings::class);
            $settings = $this->settingsRepository->CreateOrUpdate($form);
            if($request->ajax()) {
                return response()->json([
                    'media' => $settings,
                    'status' => __('admin.typed_data.success')
                ]);
            }
            else {
                flash(__('admin.typed_data.success'))->success();
                return redirect()->route('settings.index');
            }
        }
}
