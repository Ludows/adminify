<?php

namespace Ludows\Adminify\Models;

use Ludows\Adminify\Traits\Urlable;
use Ludows\Adminify\Traits\Sitemapable;
use Ludows\Adminify\Traits\HasSeo;
use VanOns\Laraberg\Models\Gutenbergable;


use ClassicModel; 

class ContentTypeModel extends ClassicModel
{
    use Urlable;
    use HasSeo;
    use Sitemapable;
    use Gutenbergable;

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
