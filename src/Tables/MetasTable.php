<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;

class MetasTable extends TableManager {
    public function getDropdownManagerClass() {
        return App\Adminify\Dropdowns\Metas::class;
    }
    public function getModelClass() {
        return App\Adminify\Models\Meta::class;
    }
}
