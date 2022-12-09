<?php

namespace Ludows\Adminify\Models;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

use Ludows\Adminify\Models\ClassicModel;
use Spatie\Menu\Laravel\Link;

class Pwa extends ClassicModel
{
    public $MultilangTranslatableSwitch = [];

    public $useSlugGeneration = false;

    public function toFeedItem(): FeedItem {}
    public function getSearchResult() : SearchResult {}

    protected $fillable = [
        // 'type',
        // 'data',
    ];

    public $enable_searchable = false;
    public $enable_revisions = false;

    public function getLinks($menuBuilder, $arrayDatas) {
        if($arrayDatas['user']->hasPermissionTo('create_settings') && $arrayDatas['features']['setting']) {
            $menuBuilder->add( Link::to( $arrayDatas['multilang'] ? '/admin/pwa?lang='. $arrayDatas['lang'] : '/admin/pwa', '<i class="ni ni-single-copy-04"></i> '.__('admin.menuback.pwa'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
        }
    }
}
