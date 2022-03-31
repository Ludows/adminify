<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;

class CommentTable extends TableManager {
    public function getDropdownManagerClass() {
        return App\Adminify\Dropdowns\Comment::class;
    }
    public function getModelClass() {
        return App\Adminify\Models\Comment::class;
    }
}
