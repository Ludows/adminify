<?php

namespace Ludows\Adminify\Http\Controllers\Front;

use Illuminate\Http\Request;
use Ludows\Adminify\Models\Page;
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

            return view("layouts.front.pages.index", ['seo' => $seo, 'type' => $type, 'model' => $page, 'user' => $user, 'lang' => $request->lang]);
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


            return view("layouts.front.pages.index", ['seo' => $seo, 'type' => $type, 'model' => $slug, 'user' => $user, 'lang' => $request->lang]);

        }

        public function handleSlug($slug) {
            $searchable = config('site-settings')['searchable-front'];
            $config = config('site-settings');
            $request = request();
            $multilang = $config['multilang'];
            $lang = \LaravelGettext::getLocale();

            $slug = explode('/', $slug);
            $slugCount = count($slug);

            $defaultResponse = null;

            foreach ($searchable['models'] as $modelName => $arr) {
                # code...
                $m = new $searchable['models'][$modelName];
                $fields = $searchable['fields'][$modelName];

                if(isset($fields)) {
                    if(count($fields) == 1) {
                        if($multilang) {
                            $m = $m->where( $fields[0].'->'.$lang, '=',  $slug[$slugCount - 1]);
                        }
                        else {
                            $m = $m->where( $fields[0], '=',  $slug[$slugCount - 1]);
                        }
                    }
                    else {
                        $count_column = 0;
                        foreach ($fields as $field) {
                            # code...
                            if($count_column > 0) {
                                if($multilang) {
                                    $m = $m->orWhere( $field.'->'.$lang, '=',  $slug[$slugCount - 1]);
                                }
                                else {
                                    $m = $m->orWhere( $field, '=',  $slug[$slugCount - 1]);
                                }
                            }
                            else {
                                if($multilang) {
                                    $m = $m->where( $field.'->'.$lang, '=',  $slug[$slugCount - 1]);
                                }
                                else {
                                    $m = $m->where( $field, '=',  $slug[$slugCount - 1]);
                                }
                            }

                            $count_column++;
                        }
                    }
                }


                $result = $m->limit(1)->first();
                if($result != null) {
                    $defaultResponse = $result;
                    break;
                }


            }

            return $defaultResponse;
        }
}
