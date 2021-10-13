<?php

namespace Ludows\Adminify\Interfacable\Blocks\FormBuilder;

use Ludows\Adminify\Libs\InterfacableBlock;
use App\Adminify\Models\Forms;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Adminify\Forms\CreateForms;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class FormBlock extends InterfacableBlock {
    use FormBuilderTrait;
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
    public function addToRender() {
        $f = $this->form(CreateForms::class, [
            'method' => 'POST',
            'url' => route('forms.store')
        ]);

        $model = \Route::current()->parameter($singular);
        if($model != null) {
            return $model->fields;
        }

        return [
            'form' => $f,
            'isCreate' => empty($model) ? true : false
        ];
    }
}
