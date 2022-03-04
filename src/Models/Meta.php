<?php

namespace Ludows\Adminify\Models;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

use Ludows\Adminify\Models\ClassicModel;
use Spatie\Menu\Laravel\Link;


class Meta extends ClassicModel
{
    public $MultilangTranslatableSwitch = ['value'];

    protected $fillable = [
        'value',
        'key',
        'model_type',
        'model_id'
    ];

    protected $guarded = [];
    public $timestamps = false;

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
        if($arrayDatas['user']->hasPermissionTo('create_metas') && $arrayDatas['features']['metas']) {
            $menuBuilder->add( Link::to( $arrayDatas['multilang'] ? '/admin/metas?lang='. $arrayDatas['lang'] : '/admin/metas', '<i class="ni ni-single-copy-04"></i> '.__('admin.menuback.metas'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
            // $menuBuilder->add( Link::to( $multilang ? '/admin/tags?lang='.$lang : '/admin/tags', '<i class="ni ni-single-copy-04"></i> '.__('admin.tags.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
        }
    }

    public function toFeedItem(): FeedItem {}

}
