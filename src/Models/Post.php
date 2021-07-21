<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Comment;

use VanOns\Laraberg\Models\Gutenbergable;
use Ludows\Adminify\Traits\OnBootedModel;
use Ludows\Adminify\Traits\Urlable;
use Ludows\Adminify\Traits\Taggable;
use Spatie\Translatable\HasTranslations;
use Ludows\Adminify\Traits\MultilangTranslatableSwitch;
use Ludows\Adminify\Traits\HasSeo;
use Ludows\Adminify\Traits\Helpers;
use Ludows\Adminify\Traits\Sitemapable;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

use Ludows\Adminify\Models\ContentTypeModel;

class Post extends ContentTypeModel
{
    use Taggable;

    public $MultilangTranslatableSwitch = ['title', 'slug', 'content'];

    protected $fillable = [
        'title',
        'slug',
        'content',
        'media_id',
        'no_comments'
    ];

    public function getSearchResult() : SearchResult
    {
       $url = route('posts.edit', ['post' => $this->id]);

        return new \Spatie\Searchable\SearchResult(
           $this,
           $this->title,
           $url
        );
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
