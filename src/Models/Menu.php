<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Ludows\Adminify\Traits\OnBootedModel;
use Spatie\Translatable\HasTranslations;
use Ludows\Adminify\Traits\MultilangTranslatableSwitch;

use App\Models\MenuItem;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Ludows\Adminify\Traits\Helpers;

use Ludows\Adminify\Models\ClassicModel;

class Menu extends ClassicModel
{
    public $MultilangTranslatableSwitch = ['title', 'slug'];

    protected $fillable = [
        'title',
        'slug',
    ];

    public function getSearchResult() : SearchResult
    {
       $url = route('menus.edit', ['menu' => $this->id]);

        return new \Spatie\Searchable\SearchResult(
           $this,
           $this->title,
           $url
        );
    }

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
