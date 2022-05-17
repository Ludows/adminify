<?php

namespace Ludows\Adminify\Libs;

use Kris\LaravelFormBuilder\Form;

class MetasFormGroup extends Form {
    public function showGroup( $model = []) {
        return false;
    }
}
