<?php

namespace Ludows\Adminify\Interfacable\Blocks;

use Ludows\Adminify\Libs\InterfacableBlock;

use App\Models\Page;

class PageCard extends InterfacableBlock {
    public static function getNamedBlock() {
        return 'Page Card';
    }
    public function query() {

        $r = $this->getRequest();
        if($r->useMultilang) {
            $query = Page::lang($r->lang)->get()->all();
        }
        else {
            $query = Page::all()->all();
        }

        return $query;
    }
    public function addToRender() {
        return [];
    }
    // public function handle() {

    //     $query = $this->getQuery();

    // }
}
