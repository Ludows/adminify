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
    public $enable_revisions = false;

    public function getLinks($menuBuilder, $arrayDatas) {
        if($arrayDatas['user']->hasPermissionTo('create_settings') && $arrayDatas['features']['setting']) {
            $menuBuilder->add('settings_item', [
                'icon' => 'journal',
                'iconPrefix' => 'bi',
                'url' => $arrayDatas['multilang'] ? '/admin/settings?lang='. $arrayDatas['lang'] : '/admin/settings',
                'label' => __('admin.menuback.settings'),
            ]);
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
