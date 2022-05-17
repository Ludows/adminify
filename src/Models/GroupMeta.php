<?php

namespace Ludows\Adminify\Models;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

use Ludows\Adminify\Models\ClassicModel;
use Spatie\Menu\Laravel\Link;


class GroupMeta extends ClassicModel
{
    public $MultilangTranslatableSwitch = ['title'];

    protected $table = 'groupmetas';

    protected $fillable = [
        'title',
        'slug',
        'named_class',
        'views_name',
        'allow_filtering',
        'uuid',
        'user_id'
    ];

    public $excludes_savables_fields = [];
    public $unmodified_savables_fields = [
        'submit'
    ];

    public function getSavableForm() {
        return null;
    }

    public function getTableListing() {
        return \App\Adminify\Tables\GroupMetasTable::class;
    }

    public function getLinks($menuBuilder, $arrayDatas) {
        if($arrayDatas['user']->hasPermissionTo('create_metas') && $arrayDatas['features']['metas']) {
            $menuBuilder->add( Link::to( $arrayDatas['multilang'] ? '/admin/groupmetas?lang='. $arrayDatas['lang'] : '/admin/groupmetas', '<i class="ni ni-single-copy-04"></i> '.__('admin.menuback.groupmetas'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
            // $menuBuilder->add( Link::to( $multilang ? '/admin/tags?lang='.$lang : '/admin/tags', '<i class="ni ni-single-copy-04"></i> '.__('admin.tags.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
        }
    }

    public function toFeedItem(): FeedItem {}

    protected function cacheForValue()
    {
        return null;
    }

}
