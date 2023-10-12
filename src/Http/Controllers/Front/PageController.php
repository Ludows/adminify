<?php

namespace Ludows\Adminify\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Adminify\Models\Page;
use App\Adminify\Models\FormTrace;
use App\Adminify\Models\Mailables;
use Ludows\Adminify\Http\Controllers\Controller;

use Ludows\Adminify\Libs\PwaService;

use ReflectionClass;

use App\Adminify\Repositories\FormTraceRepository;

class PageController extends Controller
{
    public $formTraceRepo;
    public function __construct(FormTraceRepository $formTraceRepo) {
        $this->formTraceRepo = $formTraceRepo;
    }
    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        public function showIndexPage(Request $request)
        {
            return $this->processPages($request);
        }

        protected function processPages(Request $request) {
            if(method_exists($this, 'bootingView')) {
                call_user_func_array(array($this, 'bootingView'), [$request]);
            }

            $defaults_view_vars = $this->getViewsVars();

            if(method_exists($this, 'beforePageRenderView')) {
                call_user_func_array(array($this, 'beforePageRenderView'), $defaults_view_vars);
            }

            $views = $this->getPossiblesViews('Front');


            return $this->renderView($views,  $this->getViewsVars());
        }

        public function getPages(Request $request) {
            return $this->processPages($request);
        }

        public function search(Request $request) {

            $result = app()->call('App\Adminify\Http\Controllers\Back\SearchController@index', [
                $request
            ]);// controller à taper;

            // set in session the rsults
            session(['results' => $result]);

            $this->addViewsVar('results', $result);

            $views = $this->getPossiblesViews('Search');

            return $this->renderView($views, $this->getViewsVars());
        }

        public function validateForms(Request $request) {
            $all = $request->all();

            if(empty($all['form_class'])) {
                abort(404);
            }
            $form_class = (string) $all['form_class'];

            $theFormClass = frontity_form($form_class, null, false); // html parameter generation is disabled. the formClass is returned

            if (!$theFormClass->isValid()) {
                return redirect()->back()->withErrors($theFormClass->getErrors())->withInput();
            }


            // le formulaire est valide
            $FormTrace = new FormTrace();


            $values = $theFormClass->getFieldValues();
            $a = [];
            $entries = [];

            // formattage des entrées
            foreach ($values as $key => $val) {
                # code...
                if($key != "form_id") {
                    $a[] = [
                        'field_name' => $key,
                        'content' => empty($val) ? '' : $val
                    ];
                }
            }

            $trace_model = $this->formTraceRepo->addModel($FormTrace)->create([
                'label' => __('admin.formbuilder.newTrace'),
                'form_class' => $form_class,
                'entries' => json_encode($a),
                'send_time' => now()
            ]);

            // dd($theFormClass->didSendMail);

            // if($theFormClass->didSendMail == true) {
                // now we prepare to send the email.
                // dd('mail');
                $theFormClass->data([
                    'entries' => $a,
                    'form' => $theFormClass,
                ])->sendMail();
            // }

            // now we prepare the redirection type process..
            return $theFormClass->confirm();
        }

        public function getManifest() {
            $pwa = new PwaService();

            return response()->json( $pwa->renderManifest() );
        }

        public function handleSlug($slug) {

            $config = config('site-settings');
            $request = request();
            $segments = $request->segments();
            $multilang = $config['multilang'];
            $lang = lang();
            $user = user();


            $cached = cache( join('.', $segments) );
            $defaultResponse = null;

            if($cached == null) {
                abort('404');
            }

            if($cached != null) {
                $model = new $cached['model'];

                $model = $model->find($cached['model_id']);

                $url_model = $model->url;

                //dd($segments, $url_model);
                //activate front viewing for drafted content with logued user
                if(array_equal($url_model, $segments) && $model->isDrafted() && $user != null) {
                    $defaultResponse = $model;
                }

                if(array_equal($url_model, $segments) && $model->isPublished()) {
                    $defaultResponse = $model;
                }
            }


            return $defaultResponse;
        }
}
