<?php

namespace Ludows\Adminify\Models;

use Ludows\Adminify\Traits\Urlable;
use Ludows\Adminify\Traits\Sitemapable;
use Ludows\Adminify\Traits\HasSeo;
use VanOns\Laraberg\Models\Gutenbergable;
use Ludows\Adminify\Traits\Authorable;

use App\Models\User;
use App\Models\Page;
use App\Models\Statuses;

use Ludows\Adminify\Models\ClassicModel; 
use Spatie\Feed\FeedItem;

abstract class ContentTypeModel extends ClassicModel
{
    use Urlable;
    use HasSeo;
    use Sitemapable;
    use Gutenbergable;
    use Authorable;
    
    public function status() {
        return $this->HasOne(Statuses::class, 'id', 'status_id');
    }
    public function statusScope($query, $key, $operator = '=') {
        return $query->where('status_id', $operator, $key);
    }
    public function parent() {
        return $this->HasOne(Page::class, 'id', 'parent_id');
    }
    public function isPublished() {
        return $this->status_id = 1;
    }
    public function isDrafted() {
        return $this->status_id = 2;
    }
    public function isTrashed() {
        return $this->status_id = 3;
    }
    public function toFeedItem(): FeedItem
    {
        return FeedItem::create([
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->seoWith('description') ?? '',
            'updated' => $this->updated_at,
            'link' => $this->urlpath,
            'authorName' => $this->author->{$this->authorable_column},
        ]);
    }
}
