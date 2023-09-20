<?php

namespace Ludows\Adminify\Models;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;
use Ludows\Adminify\Models\ClassicModel;
use Spatie\Menu\Laravel\Link;

class Templates extends ClassicModel
{
    protected $table = 'content_type_template';
    // use HasFactory;
    // use Helpers;

    public function toFeedItem(): FeedItem {}
    public function getSearchResult() : SearchResult {}

    protected $fillable = [
        'title',
        'content'
    ];

    public $enable_searchable = false;

    public function getAdminifyAliases() {
        return [
            'templates', 'tpls'
        ];
    }

    public function getLinks($menuBuilder, $arrayDatas) {
        if($arrayDatas['user']->hasPermissionTo('create_templates') && $arrayDatas['features']['templates_content']) {
            $menuBuilder->add('template_item', [
                'icon' => 'journal',
                'iconPrefix' => 'bi',
                'url' => $arrayDatas['multilang'] ? '/admin/templates?lang='. $arrayDatas['lang'] : '/admin/templates',
                'label' => __('admin.menuback.templates'),
            ]);
        }
    }
}
