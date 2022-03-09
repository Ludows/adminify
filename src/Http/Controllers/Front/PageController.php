<?php

namespace Ludows\Adminify\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Adminify\Models\Page;
use App\Adminify\Models\FormTrace;
use App\Adminify\Models\FormEntries;
use App\Adminify\Models\Mailables;
use App\Adminify\Models\Url;
use Ludows\Adminify\Http\Controllers\Controller;

use Ludows\Adminify\Traits\SeoGenerator;
use ReflectionClass;
use Illuminate\Support\Facades\Crypt;

use App\Adminify\Repositories\FormTraceRepository;
use App\Adminify\Repositories\FormEntriesRepository;

use Mail;

class PageController extends Controller
{
    use SeoGenerator;
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

            $settings = cache('homepage');

            if($settings == null) {
                $settings = setting('homepage');
            }


            $page = Page::find( is_array($settings) ? $settings['model_id'] : $settings );

            if( $page == null ) {
                abort("404");
            }

            $reflection = new ReflectionClass($page);
            $type = $reflection->getShortName();
            $seo = $this->handleSeo($page);

            $user = user();
            if($user != null) {
                $user->role = $user->roles->first();
                unset($user->roles);
            }

            $export = ['seo' => $seo, 'type' => $type, 'model' => $page, 'user' => $user, 'lang' => lang()];

            return view("adminify::layouts.front.pages.index", ['seo' => $seo, 'type' => $type, 'model' => $page, 'user' => $user, 'lang' => lang(), 'export' => json_encode($export)]);
        }

        public function getPages($slug) {

            $reflection = new ReflectionClass($slug);
            $type = $reflection->getShortName();
            $enabled_features = get_site_key('enables_features');

            $seo = $this->handleSeo($slug);

            // dd(request());

            $user = user();
            if($user != null) {
                $user->role = $user->roles->first();
                unset($user->roles);
            }

            $export = ['seo' => $seo, 'type' => $type, 'model' => $slug, 'user' => $user, 'lang' => lang()];


            return view("adminify::layouts.front.pages.index", ['enabled_features' => $enabled_features, 'seo' => $seo, 'type' => $type, 'model' => $slug, 'user' => $user, 'lang' => lang(), 'export' => json_encode($export)]);

        }

        public function validateForms(Request $request) {
            $all = $request->all();

            $dynamic_form_config = get_site_key('dynamic_forms');
            $mail_sender = $dynamic_form_config['default_email_user'];

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

            if(!empty($dynamic_form_config['skip_autosend']) && $dynamic_form_config['skip_autosend'] == false) {
                // now we prepare to send the email.

                if(!empty($dynamic_form_config[$formDb->slug])) {
                    $mail_sender = $dynamic_form_config[$formDb->slug]['email_user'];
                }

                //find the App\Adminify\Mails\FormEntriesListingMail
                $mail = Mailables::where('mailable', 'App\Adminify\Mails\FormEntriesListingMail')->get()->first();
                if(!empty($mail->mailable)) {
                    $mail = $mail->mailable;
                }

                Mail::to($mail_sender)
                ->send(new $mail( $formDb ) );
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
