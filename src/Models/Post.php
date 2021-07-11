<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Comment;

use VanOns\Laraberg\Models\Gutenbergable;
use Ludows\Adminify\Traits\SlugUpdate;
use Ludows\Adminify\Traits\Urlable;
use Spatie\Translatable\HasTranslations;
use Ludows\Adminify\Traits\MultilangTranslatableSwitch;
use Ludows\Adminify\Traits\HasSeo;
use Ludows\Adminify\Traits\Helpers;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Post extends Model implements Searchable
{
    use Gutenbergable;
    use HasFactory;
    use SlugUpdate;
    use Urlable;
    use HasTranslations;
    use HasSeo;
    use MultilangTranslatableSwitch;
    use Helpers;

    public $MultilangTranslatableSwitch = ['title', 'slug', 'content'];

    protected $fillable = [
        'title',
        'slug',
        'content',
        'media_id',
    ];

    public function getSearchResult(): SearchResult
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
