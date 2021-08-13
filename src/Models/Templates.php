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
        'type',
        'content'
    ];

    public function getLinks($menuBuilder, $arrayDatas) {
        if($arrayDatas['user']->hasPermissionTo('manage_templates')) {
            $menuBuilder->add( Link::to( $arrayDatas['multilang'] ? '/admin/templates?lang='. $arrayDatas['lang'] : '/admin/templates', '<i class="ni ni-single-copy-04"></i> '.__('admin.templates.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
        }
    }
}
