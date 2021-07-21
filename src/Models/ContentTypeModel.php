<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use Ludows\Adminify\Traits\Urlable;
use Ludows\Adminify\Traits\Helpers;
use Ludows\Adminify\Traits\Sitemapable;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Ludows\Adminify\Traits\HasSeo;

use App\Models\ClassicModel; 

class ContentTypeModel extends ClassicModel implements Searchable, Feedable
{
    use HasFactory;
    use Urlable;
    use HasSeo;
    use Sitemapable;
    use Helpers;

    public function getSearchResult(): SearchResult
    {}

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
}
