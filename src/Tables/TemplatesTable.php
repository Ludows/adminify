<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
class TemplatesTable extends TableManager {
    public function getDropdownManagerClass() {
        return \App\Adminify\Dropdowns\Templates::class;
    }
    public function getModelClass() {
        return \App\Adminify\Models\Templates::class;
    }
}
