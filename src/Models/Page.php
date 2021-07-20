<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use VanOns\Laraberg\Models\Gutenbergable;
use Ludows\Adminify\Traits\OnBootedModel;
use Ludows\Adminify\Traits\Urlable;
use Spatie\Translatable\HasTranslations;
use Ludows\Adminify\Traits\MultilangTranslatableSwitch;
use Ludows\Adminify\Traits\HasSeo;
use Ludows\Adminify\Traits\Helpers;
use Ludows\Adminify\Traits\Sitemapable;


use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
class Page extends Model implements Searchable, Feedable
{
    use Gutenbergable;
    use OnBootedModel;
    use Urlable;
    use HasSeo;
    use HasFactory;
    use HasTranslations;
    use MultilangTranslatableSwitch;
    use Sitemapable;
    use Helpers;

    public $MultilangTranslatableSwitch = ['title', 'slug', 'content'];

    public function getSearchResult(): SearchResult
    {
       $url = route('pages.edit', ['page' => $this->id]);

        return new \Spatie\Searchable\SearchResult(
           $this,
           $this->title,
           $url
        );
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create([
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->seoWith('description') ?? '',
            'updated' => $this->updated_at,
            'link' => $this->urlpath,
            'authorName' => $this->author->name,
        ]);
    }

    protected $fillable = [
        'title',
        'slug',
        'content',
        'media_id',
        'parent_id',
    ];
    public function media()
    {
        return $this->belongsTo(Media::class,'media_id', 'id');
    }
    public function categories()
    {
       return $this->belongsToMany(Category::class);
    }
}
