<?php

namespace Ludows\Adminify\Models;

use App\Models\Category;
use App\Models\Comment;

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
        'no_comments',
        'user_id',
        'status_id'
    ];

    /**
     * Default values for attributes
     * @var  array an array with attribute as key and default as value
     */
    protected $attributes = [
        'content' => NULL,
        'no_comments' => NULL,
        'media_id' => NULL,
        'parent_id' => 0,
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
        'no_comments',
        'tags_id',
        'submit'
    ];

    public function getSavableForm() {
        return \App\Forms\UpdatePost::class;
    }

    public function getSearchResult() : SearchResult
    {
       $url = route('posts.edit', ['post' => $this->id]);

        return new \Spatie\Searchable\SearchResult(
           $this,
           $this->title,
           $url
        );
    }

    public function getTableListing() {
        return \Ludows\Adminify\Tables\PostTable::class;
    }

    public function toFeedItem(): FeedItem {}

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

    public function getcommentsThreeAttribute() {
        $a = [];
        $m = new Comment();
        $items = $m->withPostId($this->id)->root()->approved()->get();
        $allSubs = $m->SublevelAll(0)->approved()->get();
        $grouped = $allSubs->groupBy('parent_id');
        $i = 0;

        function checkCommentChilds($item, $subItems, $grouped) {
            if($grouped->has($item->id)) {
                $cibled = $grouped->get($item->id);
                $item->childs = $cibled;
                foreach ($cibled as $c) {
                    # code...
                    checkCommentChilds($c, $subItems, $grouped);
                }
            }
            return $item;
        }
        foreach ($items as $item) {
            # code...
            checkCommentChilds($item, $allSubs, $grouped);
            $a[$i] = $item;
            $i++;
        }
        return collect($a);
    }
}
