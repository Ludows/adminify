<?php

namespace Ludows\Adminify\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Kris\LaravelFormBuilder\FormBuilderTrait;

use Illuminate\Support\Facades\View;
use App\Adminify\Models\GroupMeta;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, FormBuilderTrait;

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

        //lets try to fetch all group meta with ?? specified page.name corresponding to the current view name :)

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
                    $currentForm->add('_'.$meta->uuid, 'collection', [
                        'type' => 'form',
                        'prototype' => true,
                        'label_show' => true,
                        'label' => $meta->title,
                        'prefer_input' => true,
                        'model' => !empty($request->model) ? $request->model : [],
                        'wrapper' => [
                            'id' => $meta->uuid,
                            'class' => 'form-group js-metabox-show'
                        ],
                        'options' => [    // these are options for a single type
                            'class' => $theClass,
                            'label' => false,
                        ]
                    ]);
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
