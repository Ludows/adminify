<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;

class FormsTable extends TableManager {
    public function getDropdownManagerClass() {
        return App\Adminify\Dropdowns\Forms::class;
    }
    public function getModelClass() {
        return App\Adminify\Models\Forms::class;
    }
}
