<?php

namespace Ludows\Adminify\Models;

use App\Models\MenuItem;
use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

use Ludows\Adminify\Models\ClassicModel;
use Spatie\Menu\Laravel\Link;

class Menu extends ClassicModel
{
    public $MultilangTranslatableSwitch = ['title', 'slug'];

    protected $fillable = [
        'title',
        'slug',
    ];

    public $excludes_savables_fields = [];
    public $unmodified_savables_fields = [
        'submit'
    ];

    public function getSavableForm() {
        return null;
    }

    public function getTableListing() {
        return \Ludows\Adminify\Tables\MenuTable::class;
    }

    public function getLinks($menuBuilder, $arrayDatas) {
        if($arrayDatas['user']->hasPermissionTo('create_menus') && $arrayDatas['features']['menu']) {
            $menuBuilder->add( Link::to( $arrayDatas['multilang'] ? '/admin/menus?lang='. $arrayDatas['lang'] : '/admin/menus', '<i class="ni ni-single-copy-04"></i> '.__('admin.menuback.menus'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
            // $menuBuilder->add( Link::to( $multilang ? '/admin/tags?lang='.$lang : '/admin/tags', '<i class="ni ni-single-copy-04"></i> '.__('admin.tags.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
        }
    }

    public function toFeedItem(): FeedItem {}

    public function scopeId($query, $id) {
        return $query->where('id', $id);
    }

    public function scopeSlug($query, $slug) {
        $request = request();
        $multilang = $request->useMultilang;
        $lang = $request->lang;
        $q = 'slug';
        if($multilang) {
            $q = 'slug->'.$lang;
        }
        return $query->where($q, $slug);
    }

    public function items() {
        return $this->belongsToMany(MenuItem::class);
    }
    public function getmakeThreeAttribute() {
        $a = [];
        $items = $this->items()->get();
        $grouped =  $items->groupBy('parent_id');
        $rootItems = [];
        $i = 0;
        foreach ($items as $item) {
            # code...

            if($item->parent_id === 0) {

                array_push($rootItems, $item->id);
                $a[$i] = $item;
                $i++;
            }
            if($item->parent_id != 0) {
                $key = array_search($item->parent_id, $rootItems);
                // dump($key, $item->parent_id, $rootItems);
                $a[$key]->childs = $grouped->get($item->parent_id);
            }

        }
        // dd($rootItems);
        return collect($a);

    }

}
