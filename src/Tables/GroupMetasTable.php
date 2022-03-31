<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;

class GroupMetasTable extends TableManager {
    public function getDropdownManagerClass() {
        return \App\Adminify\Dropdowns\GroupMetas::class;
    }
    public function getModelClass() {
        return \App\Adminify\Models\GroupMeta::class;
    }
}
