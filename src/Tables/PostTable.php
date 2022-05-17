<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
class PostTable extends TableManager {
    public function getDropdownManagerClass() {
        return \App\Adminify\Dropdowns\Post::class;
    }
    public function getModelClass() {
        return \App\Adminify\Models\Post::class;
    }
    public function getDefaultsColumns() {
        $a = parent::getDefaultsColumns();
        array_unshift($a, 'categories_id');
        array_unshift($a, 'has_tags');
        return $a;
    }
}
