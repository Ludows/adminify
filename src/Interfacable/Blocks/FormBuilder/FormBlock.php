<?php

namespace Ludows\Adminify\Interfacable\Blocks\FormBuilder;

use Ludows\Adminify\Libs\InterfacableBlock;
use App\Adminify\Models\Forms;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;


class FormBlock extends InterfacableBlock {
    public static function getNamedBlock() {
        return 'Form Block';
    }
    public function query() {
        $r = $this->getRequest();
        $query = null;
        $requestedNameRoute = $r->route()->getName();
        $routeSpl = explode('.', $requestedNameRoute);

        $singular = Str::singular($routeSpl['0']);
        $model = \Route::current()->parameter($singular);
        if($model != null) {
            return $model->fields;
        }
        return $query;
    }
    public function handle() {

    }
    public function getView() {
        return 'adminify::layouts.admin.interfacable.formbuilder.form';
    }
}
