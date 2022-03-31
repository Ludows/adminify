<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;

class TranslationTable extends TableManager {
    public function getDropdownManagerClass() {
        return \App\Adminify\Dropdowns\Translations::class;
    }
    public function getModelClass() {
        return \App\Adminify\Models\Translations::class;
    }
}
