<?php

namespace Ludows\Adminify\Interfacable\Blocks;

use Ludows\Adminify\Libs\InterfacableBlock;

use App\Models\Category;

class CategoryCard extends InterfacableBlock {
    public static function getNamedBlock() {
        return 'Category Card';
    }
    public function getPlural() {
        return 'categories';
    }
    public function limit() {
        return 3;
    }
    public function query() {
        $r = $this->getRequest();
        if($r->useMultilang) {
            $query = Category::lang($r->lang)->take($this->limit)->get()->all();
        }
        else {
            $query = Category::take($this->limit)->get()->all();
        }

        // dd($query);

        return $query;
    }
    public function handle() {

        $this->roles(['administrator', 'client']);

    }
}
