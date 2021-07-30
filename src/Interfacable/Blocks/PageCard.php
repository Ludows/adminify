<?php

namespace Ludows\Adminify\Interfacable\Blocks;

use Ludows\Adminify\Libs\InterfacableBlock;

use App\Models\Page;

class PageCard extends InterfacableBlock {
    public function query() {

        $r = this->getRequest();
        if($r->useMultilang) {
            $query = Page::lang($r->lang)->get()->all();
        }
        else {
            $query = Page::all()->all();
        }

        return $query;
    }
    // public function handle() {

    //     $query = $this->getQuery();

    // }
}
