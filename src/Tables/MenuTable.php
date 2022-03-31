<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;


class MenuTable extends TableManager {
    public function getDropdownManagerClass() {
        return \App\Adminify\Dropdowns\Menu::class;
    }
    public function getModelClass() {
        return \App\Adminify\Models\Menu::class;
    }
}
