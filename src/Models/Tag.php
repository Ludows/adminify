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

    public $excludes_savables_fields = [];
    public $unmodified_savables_fields = [
        'submit'
    ];

    public $enable_searchable = true;

    public function getSavableForm() {
        return \App\Adminify\Forms\CreateTag::class;
    }

    public function getLinks($menuBuilder, $arrayDatas) {
        if($arrayDatas['user']->hasPermissionTo('create_tags') && $arrayDatas['features']['tag']) {
            $menuBuilder->add('tags_item', [
                'icon' => 'journal',
                'iconPrefix' => 'bi',
                'url' => $arrayDatas['multilang'] ? '/admin/tags?lang='. $arrayDatas['lang'] : '/admin/tags',
                'label' => __('admin.menuback.tags'),
            ]);
        }
    }
    
    protected $fillable = [
        'title',
        'slug',
    ];
}
