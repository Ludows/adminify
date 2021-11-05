<?php

namespace Ludows\Adminify\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Adminify\Models\Page;
use App\Adminify\Models\Url;
use Ludows\Adminify\Http\Controllers\Controller;

use Ludows\Adminify\Traits\SeoGenerator;
use ReflectionClass;
use Illuminate\Support\Facades\Crypt;

use App\Adminify\Repositories\FormTraceRepository;



class PageController extends Controller
{
    use SeoGenerator;
    public $formTraceRepo;
    public function __construct(FormTraceRepository $formTraceRepo) {
        $this->formTraceRepo = $formTraceRepo;
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

            if(empty($all['form_id'])) {
                abort(404);
            }

            $theFormClass = generate_form($all['form_id'], false); // html parameter generation is disabled. the formClass is returned

            if (!$theFormClass->isValid()) {
                return redirect()->back()->withErrors($theFormClass->getErrors())->withInput();
            }
            
            // le formulaire est valide 
            $FormTrace = new FormTrace();
            $this->formTraceRepo->addModel($FormTrace)->create($theFormClass);

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
