<?php

namespace Ludows\Adminify\Http\Controllers\Back\V2;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Adminify\Forms\CreateSettings;

use App\Adminify\Http\Requests\SaveSettings;
use App\Adminify\Repositories\SettingsRepository;
use App\Adminify\Models\Settings;
use App\Adminify\Http\Controllers\Controller;


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

            $form = $this->makeForm(CreateSettings::class, [
                'method' => 'POST',
                'url' => route('settings.store'),
            ]);

            $views = $this->getPossiblesViews('Index');


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
        public function store(SaveSettings $request)
        {
            //
            $form = $this->makeForm(CreateSettings::class);
            $settings = $this->settingsRepository->CreateOrUpdate($form);

            return $this->toJson([
                'message' => __('admin.typed_data.success'),
                'entity' => $settings,
                'route' => 'settings.index'
            ]);
        }
}
