<?php

namespace Ludows\Adminify\Models;

use App\Adminify\Models\Page;
use App\Adminify\Models\Media;
use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

use Ludows\Adminify\Models\ClassicModel;
use Spatie\Menu\Laravel\Link;

class Settings extends ClassicModel
{
    public $MultilangTranslatableSwitch = ['data'];

    public $useSlugGeneration = false;

    public function toFeedItem(): FeedItem {}
    public function getSearchResult() : SearchResult {}

    protected $fillable = [
        'type',
        'data',
    ];

    public $enable_searchable = false;

    public function getLinks($menuBuilder, $arrayDatas) {
        if($arrayDatas['user']->hasPermissionTo('create_settings') && $arrayDatas['features']['setting']) {
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
