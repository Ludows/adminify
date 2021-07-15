<?php

namespace Ludows\Adminify\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Url;
use Ludows\Adminify\Http\Controllers\Controller;

use Ludows\Adminify\Traits\SeoGenerator;
use ReflectionClass;

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

        public function getPages($slug = null, Request $request) {

            if($slug == null) {
                abort(404);
            }
            $reflection = new ReflectionClass($slug);
            $type = $reflection->getShortName();

            $seo = $this->handleSeo($slug);

            $user = $request->user();
            if($user != null) {
                $user->role = $user->roles->first();
                unset($user->roles);
            }


            return view("adminify::layouts.front.pages.index", ['seo' => $seo, 'type' => $type, 'model' => $slug, 'user' => $user, 'lang' => $request->lang]);

        }

        public function handleSlug($slug) {

            $config = config('site-settings');
            $request = request();
            $segments = $request->segments();
            $multilang = $config['multilang'];
            $lang = $request->lang;

            // dd(Url::all()->all());

            // get all urls from website
            $urls = Url::all()->all();
            $defaultResponse = null;

            if(count($urls) > 0) {
                foreach ($urls as $url) {
                    # code...
                    $m_str = $url->model_name;
                    $m = new $m_str();
                    $m =  $m->where('id', $url->model_id)->get()->first();
                    $url_model = $m->url;
                    //dd($url_model);
                    if(array_equal($url_model, $segments)) {
                        $defaultResponse = $m;
                    }

                }
            }

            return $defaultResponse;
        }
}
