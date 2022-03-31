<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;

class PageTable extends TableManager {
    public function getDropdownManagerClass() {
        return \App\Adminify\Dropdowns\Page::class;
    }
    public function getModelClass() {
        return \App\Adminify\Models\Page::class;
    }
    public function getDefaultsColumns() {
        $a = parent::getDefaultsColumns();
        $a = array_unshift($a, 'categories_id');
        return $a;
    }
}
