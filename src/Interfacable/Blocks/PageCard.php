<?php

namespace Ludows\Adminify\Interfacable\Blocks;

use Ludows\Adminify\Libs\InterfacableBlock;

use App\Models\Page;

class PageCard extends InterfacableBlock {
    public static function getNamedBlock() {
        return 'Page Card';
    }
    public function getPlurial() {
        return 'pages';
    }
    public function query() {
        $config = get_site_key('dashboard');
        $r = $this->getRequest();
        if($r->useMultilang) {
            $query = Page::lang($r->lang)->take($config['limit'])->get()->all();
        }
        else {
            $query = Page::take($config['limit'])->get()->all();
        }

        return $query;
    }
    public function handle() {

        $this->roles(['administrator', 'client']);

    }
}
