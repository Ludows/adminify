<?php

namespace Ludows\Adminify\Models;

use Ludows\Adminify\Traits\Urlable;
use Ludows\Adminify\Traits\Sitemapable;
use Ludows\Adminify\Traits\HasSeo;
use Ludows\Adminify\Traits\Authorable;
use Ludows\Adminify\Traits\HasInteractsWithFront;
use Ludows\Adminify\Traits\HasFeaturedMedia;

use App\Adminify\Models\User;
use App\Adminify\Models\Page;

use Ludows\Adminify\Models\ClassicModel;
use Spatie\Feed\FeedItem;

abstract class ContentTypeModel extends ClassicModel
{
    use Urlable;
    use HasSeo;
    use Sitemapable;
    use Authorable;
    use HasInteractsWithFront;
    use HasFeaturedMedia;

    public function parent() {
        return $this->HasOne(Page::class, 'id', 'parent_id');
    }
    public function user() {
        return $this->HasOne(User::class, 'id', 'user_id');
    }
    public function getParent($id) {
        return Page::find($id);
    }

    public function defineCommentStrategy() {
        $siteKey = get_site_key('comments');
        $baseNameClass = class_basename( get_class($this) );
        return in_array($baseNameClass, $siteKey);
    }

    public function getSitemapUrl() {

        $url = '/';

        $isHomepage = is_homepage($this);


        if(!$isHomepage) {
            $url = $this->urlpath;
        }

        return $url;
    }

    public function getKeyFrontAttribute($key, $lang) {
        return $this->routeVerbs[$key][$lang];
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
