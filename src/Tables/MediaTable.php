<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;

class MediaTable extends TableManager {
    public function getDropdownManagerClass() {
        return \App\Adminify\Dropdowns\Media::class;
    }
    public function getModelClass() {
        return \App\Adminify\Models\Media::class;
    }
}
