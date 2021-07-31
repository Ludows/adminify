<?php

namespace Ludows\Adminify\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Url;
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

            $page = Page::find( setting('homepage') );

            if( $page == null ) {
                abort("404");
            }


            $reflection = new ReflectionClass($page);
            $type = $reflection->getShortName();
            $seo = $this->handleSeo($page);

            $user = $request->user();
            if($user != null) {
                $user->role = $user->roles->first();
                unset($user->roles);
            }

            return view("adminify::layouts.front.pages.index", ['seo' => $seo, 'type' => $type, 'model' => $page, 'user' => $user, 'lang' => $request->lang]);
        }

        public function getPages($slug) {

            $reflection = new ReflectionClass($slug);
            $type = $reflection->getShortName();

            $seo = $this->handleSeo($slug);

            $user = user();
            if($user != null) {
                $user->role = $user->roles->first();
                unset($user->roles);
            }


            return view("adminify::layouts.front.pages.index", ['seo' => $seo, 'type' => $type, 'model' => $slug, 'user' => $user, 'lang' => lang()]);

        }

        public function handleSlug($slug) {

            $config = config('site-settings');
            $request = request();
            $segments = $request->segments();
            $multilang = $config['multilang'];
            $lang = $request->lang;

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

                if(array_equal($url_model, $segments)) {
                    $defaultResponse = $model;
                }
            }

            //dd($defaultResponse);

            return $defaultResponse;
        }
}
