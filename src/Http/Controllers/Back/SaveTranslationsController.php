<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Forms\SaveMissingTraductions;

use App\Repositories\SaveTranslationRepository;
use Illuminate\Http\Request;

use Illuminate\Support\Str;

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
            public function edit(FormBuilder $formBuilder , Request $request)
            {

                $type = $request->get('type');
                $originLang = $request->get('from');
                $actualLang = $request->get('lang');

                if($type == null && $originLang == null) {
                    abort(403);
                }

                $config = config('site-settings');
                $id = \Route::current()->parameter($request->singleParam);

                $m = get_site_key($config['savetraductions']['models'][$type]);
                $model = new $m();


                $clsForm = $this->form($model->getSavableForm());

                $form = $formBuilder->create(SaveMissingTraductions::class, [
                    'method' => 'PUT',
                    'url' => route('savetraductions.update', ['savetraduction' => $id, 'lang' => $actualLang]),
                ], [
                    'id' => $id,
                    'type' => $type,
                    'clsForm' => $clsForm,
                    'fromLang' => $originLang,
                    'actualLang' => $actualLang,
                    'model' => $model->find($id)
                ]);

                return view("adminify::layouts.admin.pages.edit", ['form' => $form]);
            }

        public function update(Request $request)
        {
            //
            $all = $request->all();
            //dd($all);

            $config = config('site-settings');
            $m = get_site_key($config['savetraductions']['models'][$all['type']]);
            $model = new $m();
            $model = $model->find($all['id']);

            $model = $this->translationRepository->update($all, $model);
            // $this->translationRepository->update($form, $request, $traduction);

            if($request->ajax()) {
                return response()->json([
                    'translation' => $model,
                    'status' => __('admin.typed_data.updated')
                ]);
            }
            else {
                flash(__('admin.typed_data.updated'))->success();
                return redirect(url()->previous());
            }
        }
}
