<?php

namespace Ludows\Adminify\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {
        $this->admin_css = [];
        $this->admin_js = [];
        $this->view = view();
    }

    public function addJS($mixed) {
        $links = [];
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

        $this->view->share('adminJsLinks', $this->admin_js);
    }

    public function addCss($mixed) {
        $links = [];
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

        $this->view->share('adminCssLinks', $this->admin_css);
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
}
