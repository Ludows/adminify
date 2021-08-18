<?php

namespace Ludows\Adminify\Models;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;
use Ludows\Adminify\Models\ClassicModel;
use Spatie\Menu\Laravel\Link;

class Tag extends ClassicModel
{
    protected $table = 'tags';

    public $MultilangTranslatableSwitch = ['title','slug'];

    public function toFeedItem(): FeedItem {}
    public function getSearchResult() : SearchResult {}

    public $excludes_savables_fields = [];
    public $unmodified_savables_fields = [
        'submit'
    ];
    public function getSavableForm() {
        return \App\Forms\CreateTag::class;
    }

    public function getTableListing() {
        return \Ludows\Adminify\Tables\TagTable::class;
    }

    public function getLinks($menuBuilder, $arrayDatas) {
        if($arrayDatas['user']->hasPermissionTo('create_tags')) {
            $menuBuilder->add( Link::to( $arrayDatas['multilang'] ? '/admin/tags?lang='. $arrayDatas['lang'] : '/admin/tags', '<i class="ni ni-single-copy-04"></i> '.__('admin.menuback.tags'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
        }
    }
    
    protected $fillable = [
        'title',
        'slug',
    ];
}
