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
    public function scopeStatus($query, $key, $operator = '=') {
        return $query->where('status_id', $operator, $key);
    }
    public function parent() {
        return $this->HasOne(Page::class, 'id', 'parent_id');
    }
    public function getParent($id) {
        return Page::find($id);
    }
    public function isPublished() {
        return $this->status_id == Statuses::PUBLISHED_ID;
    }
    public function isDrafted() {
        return $this->status_id == Statuses::DRAFTED_ID;
    }
    public function isTrashed() {
        return $this->status_id == Statuses::TRASHED_ID;
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
    public function getRenderContentAttribute() {
        
        $content = $this->content;

        $shortcodes = parse_shortcode($content);

        if(!empty($shortcodes)) {
            foreach ($shortcodes as $shortcode) {
                # code...
                if(is_shortcode($shortcode->getName())) {
                    $s = get_shortcode($shortcode->getName());

                    $shortcodeClass = new $s['class']([
                        'text' => $content,
                        'shortcodeName' => $s['name'],
                        'shortcodeClass' => $s['class']
                    ]);

                    $content = $shortcodeClass->parsed;
                }
            }
        }

        return $content;
    }
}
