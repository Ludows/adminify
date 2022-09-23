<?php

namespace Ludows\Adminify\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Ludows\Adminify\Traits\SeoGenerator;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use Illuminate\Support\Facades\View;
use App\Adminify\Models\GroupMeta;
use Error;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, FormBuilderTrait, SeoGenerator;

    public $view_key_cache_prefix = 'front_view';

    public function __construct() {
        $this->admin_css = [];
        $this->admin_js = [];
        $this->export = [];
        $this->viewVars = [];
    }

    public function addJS($mixed) {
        $links = [];

        $view = view();
        if(is_array($mixed)) {
            $links = $mixed;
        }

        if(is_string($mixed)) {
            $links[] = $mixed;
        }

        foreach ($links as $link) {
            # code...
            $this->admin_js[] = $link;
        }

        $view->share('adminJsLinks', $this->admin_js);
    }

    public function addCss($mixed) {
        $links = [];
        $view = view();
        if(is_array($mixed)) {
            $links = $mixed;
        }

        if(is_string($mixed)) {
            $links[] = $mixed;
        }

        foreach ($links as $link) {
            # code...
            $this->admin_css[] = $link;
        }

        $view->share('adminCssLinks', $this->admin_css);
    }

    public function sendResponse($model, $routeName, $traductionKey, $ajaxKey = 'model') {
        $r = request();

        if($r->ajax()) {
            return response()->json([
                $ajaxKey => $model,
                'message' => __('admin.typed_data.success')
            ]);
        }
        else {
            flash(__($traductionKey))->success();
            return redirect()->route($routeName);
        }
    }
    public function sendResponseWith($model, $url, $traductionKey, $ajaxKey = 'model') {
        $r = request();

        if($r->ajax()) {
            return response()->json([
                $ajaxKey => $model,
                'message' => __('admin.typed_data.success')
            ]);
        }
        else {
            flash(__($traductionKey))->success();
            return redirect($url);
        }
    }
    public function makeForm($class = '', $options = [], $datas = []) {

        //mount the form
        $f = $this->form($class, $options, $datas);

        // merge to the request
        merge_to_request('form', $f);

        //mount metas if present for the page
        $this->appendMetas();

        // merge to the view the form
        view()->share('form', $f);


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
    public function renderView($pathView, $vars) {

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

        $view = view($pathView,  $vars);

        if(config('app.env') == 'production') {
            cache([$key => $view->render()]);

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
        $request = request();
        $currentRoute = $request->currentRouteName;
        $currentForm = $request->form;

        //lets try to fetch all group meta with à specified page.name corresponding to the current view name :)

        $m = new GroupMeta();
        $m = $m->where('views_name', 'LIKE', '%'. $currentRoute .'%');
        $m = $m->get();
        // dd($m);
        $metaboxes = [];


        if($m->count() > 0) {
            // we have group to append to the form.
            foreach($m as $meta) {
                $showGroup = true;
                $theClass = adminify_get_class($meta->named_class, ['app:metas', 'app:adminify:metas'], false);
                $metaClass = app()->make($theClass);

                if((bool) $meta->allow_filtering) {
                    $showGroup = $metaClass->showGroup( !empty($request->model) ? $request->model : [] );
                }

                // dd($showGroup, (bool) $meta->allow_filtering);

                if($showGroup) {
                    $metaboxes[] = $meta->uuid;
                    $currentForm->add('_'.$meta->uuid, $metaClass->getTypeField(), array_merge($metaClass->getDefaults(), [
                        'label' => $metaClass->getMetaboxTitle(),
                        'model' => !empty($request->model) ? $request->model : [],
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

            //dd($metaboxes);

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
