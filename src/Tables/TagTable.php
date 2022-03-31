<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
class TagTable extends TableManager {
    public function getDropdownManagerClass() {
        return App\Adminify\Dropdowns\Tags::class;
    }
    public function getModelClass() {
        return App\Adminify\Models\Tag::class;
    }
}
