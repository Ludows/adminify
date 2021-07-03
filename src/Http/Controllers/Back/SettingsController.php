<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Forms\CreateSettings;

use Ludows\Adminify\Http\Requests\SaveSettings;
use Ludows\Adminify\Repositories\SettingsRepository;
use App\Models\Settings;
use Ludows\Adminify\Http\Controllers\Controller;


class SettingsController extends Controller
{
    use FormBuilderTrait;
    public function __construct(SettingsRepository $settingsRepository) {

        $this->settingsRepository = $settingsRepository;
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
            $settings = $this->settingsRepository->CreateOrUpdate($form, $request);
            if($request->ajax()) {
                return response()->json([
                    'media' => $settings,
                    'status' => 'Les Paramètres ont bien mis à jour !'
                ]);
            }
            else {
                flash('Les Paramètres ont bien mis à jour !')->success();
                return redirect()->route('settings.index');
            }
        }
}
