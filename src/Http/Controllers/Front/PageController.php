<?php

namespace Ludows\Adminify\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Adminify\Models\Page;
use App\Adminify\Models\Url;
use Ludows\Adminify\Http\Controllers\Controller;

use Ludows\Adminify\Traits\SeoGenerator;
use ReflectionClass;
use Illuminate\Support\Facades\Crypt;


class PageController extends Controller
{
    use SeoGenerator;
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

        public function validateForms(Request $request) {}

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

                // if($cached['parent_id'] != null) {
                //     $model = $model->find($cached['parent_id']);
                //     dd($cached, $model);
                // }
                // else {
                //     $model = $model->find($cached['model_id']);
                // }

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

            //dd($defaultResponse);

            return $defaultResponse;
        }
}
