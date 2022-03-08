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

        $f = $this->form($class, $options, $datas);

        merge_to_request('form', $f);

        view()->share('form', $f);

        return $f;
    }
}
