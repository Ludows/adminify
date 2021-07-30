<?php

namespace Ludows\Adminify\Interfacable\Blocks;

use Ludows\Adminify\Libs\InterfacableBlock;

use App\Models\Menu;

class MenuCard extends InterfacableBlock {
    public static function getNamedBlock() {
        return 'Menu Card';
    }
    public function getPlural() {
        return 'menus';
    }
    public function limit() {
        return 3;
    }
    public function query() {
        $r = $this->getRequest();
        if($r->useMultilang) {
            $query = Menu::lang($r->lang)->take($this->limit)->get()->all();
        }
        else {
            $query = Menu::take($this->limit)->get()->all();
        }

        // dd($query);

        return $query;
    }
    public function handle() {

        $this->roles(['administrator', 'client']);

    }
}
