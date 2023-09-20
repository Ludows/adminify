<?php

namespace Ludows\Adminify\Libs;

use Closure;
use Error;
use Kris\LaravelFormBuilder\Fields\FormField;

class BaseFormField extends FormField {

    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return '';
    }

    public function makeRenderableField($props = []) {
        return array_merge($this->getOptions(), $props);
    }

    public function toArray() {
        return $this->makeRenderableField();
    }
    public function toJson() {
        return json_encode($this->makeRenderableField(), true);
    }

}