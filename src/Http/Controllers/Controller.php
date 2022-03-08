<?php

namespace Ludows\Adminify\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Kris\LaravelFormBuilder\FormBuilderTrait;

use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, FormBuilderTrait;

    public function __construct() {
        $this->admin_css = [];
        $this->admin_js = [];
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
        //mount metas if present for the page
        $this->appendMetas();

        // merge to the request
        merge_to_request('form', $f);

        // merge to the view the form
        view()->share('form', $f);
        

        return $f;
    }
    private function appendMetas() {
        $request = request();
        $currentRoute = $request->currentRouteName;
        $currentForm = $request->form;

        //lets try to fetch all group meta with à specified page.name corresponding to the current view name :)

        $m = new GroupMeta();
        $m = $m->where('view_name', 'LIKE', '%'. $currentRoute .'%');
        $m = $m->get();

        if($m->count() > 0) {
            // we have group to append to the form.
            foreach($m as $meta) {
                $currentForm->add('_metas-'.$meta->uuid, 'collection', [
                    'type' => 'form',
                    'prototype' => true,
                    'label_show' => true,
                    'label' => $meta->title,
                    'prefer_input' => true,
                    'wrapper' => [
                        'class' => 'form-group js-metabox-show'
                    ],
                    'options' => [    // these are options for a single type
                        'class' => $meta->named_class,
                        'label' => false,
                    ]
                ]);
            }
        }
    }
}
