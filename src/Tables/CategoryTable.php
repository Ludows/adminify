<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;

class CategoryTable extends TableManager {
   public function getDropdownManagerClass() {
    return App\Adminify\Dropdowns\Category::class;
   }
   public function getModelClass() {
    return App\Adminify\Models\Category::class;
   }
}
