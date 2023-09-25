<?php

namespace Ludows\Adminify\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Kris\LaravelFormBuilder\FormBuilderTrait;

use Illuminate\Support\Facades\View;
use App\Adminify\Models\GroupMeta;
use Error;
use Inertia\Inertia;
use Ludows\Adminify\Traits\SetupRouting;
use Ludows\Adminify\Traits\TableManagerable;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, FormBuilderTrait, SetupRouting, TableManagerable;

    public $view_key_cache_prefix = 'front_view';

    public function __construct() {
        $this->admin_css = [];
        $this->admin_js = [];
        $this->export = [];
        $this->viewVars = [];
    }

    public function getPossiblesViews($named = '') {

        $shareds = inertia()->getShared();
        $possibles_names = [];

        if($shareds['isBack']) {
            $possibles_names[] = ucfirst($shareds['singleParam']).'-'.$named;
            $possibles_names[] = $named;
        }

        if(is_auth_routes()) {
            $possibles_names[] = 'Auth';
        }

        // @todo 
        if($shareds['isFront']) {
            $classicFrontTpl = 'Front';
            $classicOverrideTpl = 'Custom';
            $currentFrontName = '';
            $isHome = false;
            
            if($shareds['isHome']) {
                $currentFrontName = 'Home';
                $isHome = true;
            }
            if($shareds['isContentModel']) {
                $currentFrontName = 'Content';
            }
            if($shareds['isBlogPage']) {
                $currentFrontName = 'Posts';
            }
            if($shareds['isSearch']) {
                $currentFrontName = 'Search';
            }
            if($shareds['isPage']) {
                $currentFrontName = 'Page';
            }
            

            if($shareds['model'] && !$isHome) {
                $model = $shareds['model'];
                $slug = $model->slug;
                $id = $model->id;
                $type = $shareds['type'];

                $possibles_names[] = $currentFrontName.'-'.$id;
                $possibles_names[] = $currentFrontName.'-'.$slug;
                $possibles_names[] = $currentFrontName.'-'.$type;
            }

            $possibles_names[] = $classicFrontTpl.'-'.$classicOverrideTpl;
            $possibles_names[] = $classicFrontTpl;
            // $currentFrontName = 'Front';
        }


        return json_encode($possibles_names);
    }


    public function toJson($datas = []) {
        return response()->json($datas);
    }
    public function toRoute($routeName, $datas = []) {
        return to_route($routeName)->with($datas);
    }
    public function makeForm($class = '', $options = [], $datas = []) {

        $inertia = inertia();
        //mount the form
        $f = $this->form($class, $options, $datas);

        // merge to the request
        // merge_to_request('form', $f);
        $inertia->share('form', $f);

        //mount metas if present for the page
        $this->appendMetas();

        return $f;
    }
    public function hasKeyInCache($key) {
        return cache()->has($key);
    }
    public function getKeysViews() {
        $response_cache = cache('_generated_views_keys');
        return empty($response_cache) ? '' : $response_cache;
    }
    public function generateCacheKey($model) {

        $generate = [];

        if(!empty($model)) {
            $generate[] = lowercase(get_class($model));
            if(!empty($model->id)) {
                $generate[] = $model->id;
            }
            if(!empty($model->slug)) {
                $generate[] = $model->slug;
            }
        }

        return $this->view_key_cache_prefix.'_'.join('_', $generate);
    }
    public function renderView($Component, $vars) {

        if(empty($vars['model'])) {
            throw new Error('Model is required for view key generation');
        }

        $key = $this->generateCacheKey($vars['model']);
        $all_keys = $this->getKeysViews();
        $all_keys_spl = explode(',', $this->getKeysViews());


        if(!in_array($key, $all_keys_spl)) {
            $all_keys_spl[] = $key;
        }


        if($this->hasKeyInCache($key) && config('app.env') == 'production') {
            return cache($key);
        }

        
        $view = Inertia::render($Component, $vars);
        // the old way view($pathView,  $vars);

        if(config('app.env') == 'production') {
            cache([$key => $view]);

            cache(['_generated_views_keys' => join(',',$all_keys_spl)]);
        }

        return $view;
    }
    public function getViewsVars() {
        $this->viewVars['export'] = json_encode($this->export);
        return $this->viewVars;
    }
    public function addViewsVars($array) {
        foreach ($array as $arrayKey => $arrayValue) {
            # code...
            $this->addViewsVar($arrayKey, $arrayValue);
        }
        return $this;
    }
    public function addViewsVar($name = '', $value = '', $isExportable = true) {
        if(empty($this->viewVars[$name])) {
            $this->viewVars[$name] = $value;
            if($isExportable) {
                $this->export[$name] = $value;
            }
        }
        return $this;
    }
    private function appendMetas() {
        $inertia = inertia();
        $shared = $inertia->getShared();
        $currentRoute = $shared['currentRouteName'];
        $currentForm = $shared['form'];

        //lets try to fetch all group meta with à specified page.name corresponding to the current view name :)

        $m = new GroupMeta();
        $m = $m->where('views_name', 'LIKE', '%'. $currentRoute .'%');
        $m = $m->get();
        $metaboxes = [];


        if($m->isNotEmpty()) {
            // we have group to append to the form.
            foreach($m as $meta) {
                $showGroup = true;
                $theClass = adminify_get_class($meta->named_class, ['app:metas', 'app:adminify:metas'], false);

                $metaClass = app()->make($theClass);

                if((bool) $meta->allow_filtering) {
                    $showGroup = $metaClass->showGroup( !empty($shared['model']) ? $shared['model'] : [] );
                }

                // dd($showGroup, (bool) $meta->allow_filtering);

                if($showGroup) {
                    $metaboxes[] = $meta->uuid;
                    $currentForm->add('_'.$meta->uuid, $metaClass->getTypeField(), array_merge($metaClass->getDefaults(), [
                        'label' => $metaClass->getMetaboxTitle(),
                        'model' => !empty($shared['model']) ? $shared['model'] : [],
                        'wrapper' => [
                            'id' => $meta->uuid,
                        ],
                        'options' => [    // these are options for a single type
                            'class' => $theClass,
                            'label' => false,
                        ]
                    ]));

                    
                }

            }

            if(!empty($metaboxes)) {
                // we retrieve all metaboxes attached to page. now link in the form for register in db
                $currentForm->add('_metaboxes', 'hidden', [
                    'value' => implode(', ', $metaboxes)
                ]);

            }

        }
        return $this;
    }
}
