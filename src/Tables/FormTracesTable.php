<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;

class FormTracesTable extends TableManager {
    public function __construct() {
        parent::__construct();
        $this->showBtnCreate = false;
    }
    public function getDropdownManagerClass() {
        return \App\Adminify\Dropdowns\FormTraces::class;
    }
    public function getModelClass() {
        return \App\Adminify\Models\FormTrace::class;
    }
}
