<?php

namespace Ludows\Adminify\Interfacable\Blocks;

use Ludows\Adminify\Libs\InterfacableBlock;

use App\Models\Page;

class PageCard extends InterfacableBlock {
    public static function getNamedBlock() {
        return 'Page Card';
    }
    public function getPlural() {
        return 'pages';
    }
    public function limit() {
        return 3;
    }
    public function query() {
        $r = $this->getRequest();
        if($r->useMultilang) {
            $query = Page::lang($r->lang)->take($this->limit)->get()->all();
        }
        else {
            $query = Page::take($this->limit)->get()->all();
        }

        return $query;
    }
    public function handle() {

        $this->roles(['administrator', 'client']);

    }
}
