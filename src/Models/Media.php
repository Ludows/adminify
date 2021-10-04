<?php

namespace Ludows\Adminify\Models;

use App\Adminify\Models\Post;
use App\Adminify\Models\User;
use Ludows\Adminify\Traits\PathableMedia;
use Ludows\Adminify\Traits\Authorable;

use Ludows\Adminify\Models\ClassicModel;
use Spatie\Feed\FeedItem;
use Spatie\Searchable\SearchResult;
use Spatie\Menu\Laravel\Link;

class Media extends ClassicModel
{
    use PathableMedia;
    use Authorable;

    protected $table = 'medias';

    public $MultilangTranslatableSwitch = ['alt', 'description'];

    public $sitemapCallable = 'path';

    public $searchable_label = 'src';

    protected $fillable = [
        'src', //the path you uploaded the image
        'mime_type',
        'description',
        'alt',
        'user_id'
    ];
    
    /**
     * Default values for attributes
     * @var  array an array with attribute as key and default as value
     */
    protected $attributes = [
        'alt' => NULL,
        'description' => NULL,
        'user_id' => 0,
     ];

    public function getTableListing() {
        return \Ludows\Adminify\Tables\MediaTable::class;
    }

    public function toFeedItem(): FeedItem {}

    public function getPathAttribute() {
        return $this->getFullPath($this->src) . '/' . $this->src;
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function user() {
        return $this->HasOne(User::class, 'id', 'user_id');
    }

    public function getLinks($menuBuilder, $arrayDatas) {
        if($arrayDatas['user']->hasPermissionTo('create_medias') && $arrayDatas['features']['media']) {
            $menuBuilder->add( Link::to( $arrayDatas['multilang'] ? '/admin/medias?lang='. $arrayDatas['lang'] : '/admin/medias', '<i class="ni ni-image"></i> '.__('admin.menuback.medias'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
            // $menuBuilder->add( Link::to( $multilang ? '/admin/tags?lang='.$lang : '/admin/tags', '<i class="ni ni-single-copy-04"></i> '.__('admin.tags.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
        }
    }
}
