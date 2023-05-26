<?php

namespace Ludows\Adminify\Models;

use App\Adminify\Models\Post;
use App\Adminify\Models\User;
use Ludows\Adminify\Traits\Authorable;

use Ludows\Adminify\Models\ClassicModel;
use Spatie\Feed\FeedItem;
use Spatie\Searchable\SearchResult;
use Spatie\Menu\Laravel\Link;

class Media extends ClassicModel
{
    use Authorable;

    protected $table = 'medias';

    public $MultilangTranslatableSwitch = ['alt', 'description'];

    public $searchable_label = 'src';
    public $enable_searchable = false;

    protected $useSlugGeneration = false;
    public $enable_revisions = false;

    protected $appends = [
        'path',
        'relativepath'
    ];

    protected $fillable = [
        'src', //the path you uploaded the image
        'mime_type',
        'description',
        'folder',
        'size',
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

    public function toFeedItem(): FeedItem {}

    public function getPathAttribute() {
        return $this->getFullPath();
    }

    public function getRelativePathAttribute() {
        return $this->getRelativePath();
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function user() {
        return $this->HasOne(User::class, 'id', 'user_id');
    }

    public function scopeMimetype($query, $key, $operator = '=') {
        return $query->where('mime_type', $operator, $key);
    }

    public function scopeFolder($query, $key, $operator = '=') {
        return $query->where('folder', $operator, $key);
    }

    public function scopeSrc($query, $key, $operator = '=') {
        return $query->where('src', $operator, $key);
    }

    public function getLinks($menuBuilder, $arrayDatas) {
        if($arrayDatas['user']->hasPermissionTo('create_medias') && $arrayDatas['features']['media']) {
            $menuBuilder->add('media_item', [
                'icon' => 'file-earmark-image',
                'iconPrefix' => 'bi',
                'url' => $arrayDatas['multilang'] ? '/admin/medias?lang='. $arrayDatas['lang'] : '/admin/medias',
                'label' => __('admin.menuback.medias'),
            ]);
            // $menuBuilder->add( Link::to( $multilang ? '/admin/tags?lang='.$lang : '/admin/tags', '<i class="ni ni-single-copy-04"></i> '.__('admin.tags.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
        }
    }
}
