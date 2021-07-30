<?php

namespace Ludows\Adminify\Interfacable\Blocks;

use Ludows\Adminify\Libs\InterfacableBlock;

use App\Models\Traductions;

class MediaCard extends InterfacableBlock {
    public static function getNamedBlock() {
        return 'Traductions Card';
    }
    public function getPlural() {
        return 'traductions';
    }
    public function showColumn() {
        return 'key';
    }
    public function limit() {
        return 3;
    }
    public function query() {
        $r = $this->getRequest();
        if($r->useMultilang) {
            $query = Traductions::lang($r->lang)->take($this->limit)->get()->all();
        }
        else {
            $query = Traductions::take($this->limit)->get()->all();
        }

        // dd($query);

        return $query;
    }
    public function handle() {

        $this->roles(['administrator', 'client']);

    }
}
