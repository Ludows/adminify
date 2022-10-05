<?php

namespace Ludows\Adminify\Models;

use Ludows\Adminify\Models\ClassicModel;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;
use Spatie\Menu\Laravel\Link;
class Comment extends ClassicModel
{
    protected $table = 'comments';

    public function toFeedItem(): FeedItem {}
    public function getSearchResult() : SearchResult {}

    public $enable_searchable = false;

    public $MultilangTranslatableSwitch = ['comment'];

    protected $useSlugGeneration = false;

    protected $fillable = [
        'comment',
        'parent_id',
        'user_id',
        'model_id',
        'model_class',
        'is_moderated',
    ];

    /**
     * Default values for attributes
     * @var  array an array with attribute as key and default as value
     */
    protected $attributes = [
        'user_id' => NULL,
        'is_moderated' => 0,
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'model_id');
    }

    public function getLinks($menuBuilder, $arrayDatas) {
        if($arrayDatas['user']->hasAnyRole('administrator', 'editor') && $arrayDatas['features']['comment']) {
            $menuBuilder->add( Link::to( $arrayDatas['multilang'] ? '/admin/comments?lang='. $arrayDatas['lang'] : '/admin/comments', '<i class="ni ni-single-copy-04"></i> '.__('admin.menuback.comments'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
