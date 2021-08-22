<?php

namespace Ludows\Adminify\Models;

use App\Models\Page;
use App\Models\Media;
use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

use Ludows\Adminify\Models\ClassicModel;
use Spatie\Menu\Laravel\Link;

class Settings extends ClassicModel
{
    public $MultilangTranslatableSwitch = ['data'];

    public function toFeedItem(): FeedItem {}
    public function getSearchResult() : SearchResult {}

    protected $fillable = [
        'type',
        'data',
    ];

    public function getLinks($menuBuilder, $arrayDatas) {
        if($arrayDatas['user']->hasPermissionTo('create_settings')) {
            $menuBuilder->add( Link::to( $arrayDatas['multilang'] ? '/admin/settings?lang='. $arrayDatas['lang'] : '/admin/settings', '<i class="ni ni-single-copy-04"></i> '.__('admin.menuback.settings'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
        }
    }

    public function media()
    {
        return $this->belongsTo(Media::class,'data', 'id');
    }

    public function page() {
        return $this->belongsTo(Page::class, 'data', 'id');
    }
}
