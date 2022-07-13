<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;

class UserTable extends TableManager {
    public function query() {
        $datas = $this->getDatas();
        $modelClass = $this->getModelClass();
        $config = $this->getConfig();

        $results = null;

        if(isset($datas['results'])) {
            $results = $datas['results'];
        }
        else {
            $results = $modelClass::whereRaw('LENGTH(email) > 0')->paginate($config['limit'], ['*']);
        }

        $this->setResults($results);
    
        return $this;
    }
    public function getDropdownManagerClass() {
        return \App\Adminify\Dropdowns\Users::class;
    }
    public function getModelClass() {
        return \App\Adminify\Models\User::class;
    }
}
