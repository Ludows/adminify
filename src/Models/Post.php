<?php

namespace Ludows\Adminify\Models;

use App\Adminify\Models\Category;
use App\Adminify\Models\Comment;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;
use Ludows\Adminify\Traits\Taggable;

use Ludows\Adminify\Models\ContentTypeModel;
use Spatie\Menu\Laravel\Link;

class Post extends ContentTypeModel
{
    use Taggable;

    public $MultilangTranslatableSwitch = ['title', 'slug', 'content'];

    protected $fillable = [
        'title',
        'slug',
        'content',
        'media_id',
        'user_id',
        'status_id'
    ];

    /**
     * Default values for attributes
     * @var  array an array with attribute as key and default as value
     */
    protected $attributes = [
        'content' => NULL,
        'media_id' => NULL,
    ];
    
    public $excludes_savables_fields = [
        'media_id',
        'parent_id',
        'status_id'
    ];
    
    public $unmodified_savables_fields = [
        'content',
        'categories_id',
        'user_id',
        'tags_id',
        'submit'
    ];

    public function getSavableForm() {
        return \App\Adminify\Forms\UpdatePost::class;
    }

    public function media()
    {
        return $this->belongsTo(Media::class,'media_id', 'id');
    }
    public function categories()
    {
       return $this->belongsToMany(Category::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getLinks($menuBuilder, $arrayDatas) {
        if($arrayDatas['user']->hasPermissionTo('create_posts') && $arrayDatas['features']['post']) {
            $menuBuilder->add( Link::to( $arrayDatas['multilang'] ? '/admin/posts?lang='. $arrayDatas['lang'] : '/admin/posts', '<i class="ni ni-single-copy-04"></i> '.__('admin.menuback.posts'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
            // $menuBuilder->add( Link::to( $multilang ? '/admin/tags?lang='.$lang : '/admin/tags', '<i class="ni ni-single-copy-04"></i> '.__('admin.tags.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
        }
    }
}
