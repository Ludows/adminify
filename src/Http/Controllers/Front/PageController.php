<?php

namespace Ludows\Adminify\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Adminify\Models\Page;
use App\Adminify\Models\FormTrace;
use App\Adminify\Models\FormEntries;
use App\Adminify\Models\Mailables;
use App\Adminify\Models\Url;
use Ludows\Adminify\Http\Controllers\Controller;

use ReflectionClass;
use Illuminate\Support\Facades\Crypt;

use App\Adminify\Repositories\FormTraceRepository;
use App\Adminify\Repositories\FormEntriesRepository;

use Mail;

class PageController extends Controller
{
    public $formTraceRepo;
    public $formEntryRepo;
    public function __construct(FormTraceRepository $formTraceRepo, FormEntriesRepository $formEntryRepo) {
        $this->formTraceRepo = $formTraceRepo;
        $this->formEntryRepo = $formEntryRepo;
    }
    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        public function index(Request $request)
        {
            if(method_exists($this, 'bootingView')) {
                call_user_func_array(array($this, 'bootingView'), $request);
            }

            $settings = cache('homepage');

            if($settings == null) {
                $settings = setting('homepage');
            }

            if( empty($settings) ) {
                abort(404);
            }



            $page = Page::find( is_array($settings) ? $settings['model_id'] : $settings );


            $reflection = new ReflectionClass($page);
            $type = $reflection->getShortName();
            $seo = is_content_type_model($page) ? $this->handleSeo($page) : null;

            $enabled_features = get_site_key('enables_features');

            $user = user();
            if($user != null) {
                $user->mainRole = $user->roles->first();
                // unset($user->roles);
            }

            $this->addViewsVars(['enabled_features' => $enabled_features, 'seo' => $seo, 'type' => lowercase($type), 'model' => $page, 'user' => $user, 'lang' => lang()]);
            $defaults_view_vars = $this->getViewsVars();

            if(method_exists($this, 'beforePageRenderView')) {
                call_user_func_array(array($this, 'beforePageRenderView'), $defaults_view_vars);
            }



            return $this->renderView("theme::". $request->theme .".index",  $this->getViewsVars());
        }

        public function getPages(Request $request) {

            // dd($request->route()->getName(), $request->model );
            $slug = $request->model;
            $reflection = new ReflectionClass($slug);
            $type = $reflection->getShortName();
            $enabled_features = get_site_key('enables_features');

            if(method_exists($this, 'bootingView')) {
                call_user_func_array(array($this, 'bootingView'), $request);
            }

            $seo = is_content_type_model($slug) ? $this->handleSeo($slug) : null;

            // dd(request());

            $user = user();
            if($user != null) {
                $user->mainRole = $user->roles->first();
                // unset($user->roles);
            }

            $this->addViewsVars(['enabled_features' => $enabled_features, 'seo' => $seo, 'type' => lowercase($type), 'model' => $slug, 'user' => $user, 'lang' => lang()]);
            $defaults_view_vars = $this->getViewsVars();

            if(method_exists($this, 'beforePageRenderView')) {
                call_user_func_array(array($this, 'beforePageRenderView'), $defaults_view_vars);
            }


            return $this->renderView("theme::". $request->theme .".index",  $this->getViewsVars());

        }

        public function search(Request $request) {

            $result = app()->call('App\Adminify\Http\Controllers\Back\SearchController@index', [
                $request
            ]);// controller à taper;

            // set in session the rsults
            session(['results' => $result]);

            $this->addViewsVar('results', $result);

            return view("theme::". $request->theme .".index", $this->getViewsVars());
        }

        public function validateForms(Request $request) {
            $all = $request->all();

            $dynamic_form_config = get_site_key('dynamic_forms');

            if(empty($all['form_id'])) {
                abort(404);
            }
            $formId = (int) $all['form_id'];

            $theFormClass = generate_form($formId, false); // html parameter generation is disabled. the formClass is returned

            if (!$theFormClass->isValid()) {
                return redirect()->back()->withErrors($theFormClass->getErrors())->withInput();
            }


            // le formulaire est valide
            $formDb = get_form($formId);
            $FormTrace = new FormTrace();


            $values = $theFormClass->getFieldValues();
            $a = [];
            $entries = [];

            $trace_model = $this->formTraceRepo->addModel($FormTrace)->create([
                'label' => __('admin.formbuilder.newTrace'),
                'form_id' => $formId,
                'send_time' => now()
            ]);

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



            // et hop on inscrit en db
            foreach ($a as $entryKey => $entryVal) {
                $FormEntries = new FormEntries();

                $entry_model = $this->formEntryRepo->addModel($FormEntries)->create($a[$entryKey]);
                $entries[] = $entry_model;

                $trace_model->entries()->attach([
                    $trace_model->id => ['form_entries_id' => $entry_model->id]
                ]);
            }

            if(!empty($theFormClass->didSendMail) && $theFormClass->didSendMail == true) {
                // now we prepare to send the email.
                $theFormClass->sendMail();
            }

            // now we prepare the redirection type process..
            $confirmation = $formDb->confirmation->first();

            if(!empty($confirmation) && $confirmation->type == 'samepage') {
                $url = url()->previous();
            }

            if(!empty($confirmation) && $confirmation->type == 'page') {
                $page = Page::find( (int) $confirmation->page_id );
                $url = $page->urlPath;
            }

            if(!empty($confirmation) && $confirmation->type == 'redirect') {
                $url = $confirmation->redirect_url;
            }

            if(empty($confirmation)) {
                // fallback to previous url
                $url = url()->previous();
            }


            return redirect()->to($url)->with(['formSubmitted' => true]);
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
