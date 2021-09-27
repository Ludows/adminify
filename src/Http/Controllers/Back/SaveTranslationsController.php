<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Forms\SaveMissingTraductions;

use App\Repositories\SaveTranslationRepository;
use Illuminate\Http\Request;

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
                $return_view = [];

                if($type == null && $originLang == null) {
                    abort(403);
                }

                $config = get_site_key('register');
                $id = \Route::current()->parameter($request->singleParam);

                $m = $config[$type] ?? null;
                if(empty($m)) {
                    abort(403);
                }
                $model = new $m();

                $theSavableForm = $model->getSavableForm();
                
                $clsForm = isset($theSavableForm) ? $this->form($theSavableForm) : null;

                if($clsForm) {
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
                    $return_view['form'] = $form;
                }

                

                return view("adminify::layouts.admin.pages.edit", $return_view);
            }

        public function update(Request $request)
        {
            //
            $all = $request->all();
            //dd($all);

            $config = get_site_key('register');
            $type = $all['type'];
            $m = $config[$type] ?? null;

            if(empty($m)) {
                abort(403);
            }

            $model = new $m();
            $model = $model->find($all['id']);

            $excludes = $this->translationRepository->getExcludes();

            foreach ($all as $key => $value) {
                # code...
                if(in_array($key, $excludes)) {
                    unset($all[$key]);
                }
            }

            $model = $this->translationRepository->addModel($model)->update($all, $model);
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
