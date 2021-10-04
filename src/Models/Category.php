<?php

namespace Ludows\Adminify\Models;

use App\Adminify\Models\Post;
use App\Adminify\Models\Media;
use Ludows\Adminify\Models\ContentTypeModel;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;
use Spatie\Menu\Laravel\Link;
class Category extends ContentTypeModel
{
    public $allowSitemap = false;
    public $MultilangTranslatableSwitch = ['title', 'slug'];
    public $enable_searchable = true;

    protected $fillable = [
        'title',
        'media_id',
        'slug',
        'parent_id',
        'user_id'
    ];

    /**
     * Default values for attributes
     * @var  array an array with attribute as key and default as value
     */
    protected $attributes = [
      'media_id' => NULL,
      'user_id' => 0,
      'parent_id' => 0,
   ];

    public $excludes_savables_fields = [
      'media_id',
      'parent_id'
    ];
    public $unmodified_savables_fields = [
      'submit'
   ];
    public function getSavableForm() {
       return \App\Forms\UpdateCategory::class;
    }

    public function getTableListing() {
      return \Ludows\Adminify\Tables\CategoryTable::class;
   }

    public function getSearchResult() : SearchResult
     {
        $url = route('categories.edit', ['category' => $this->id]);

         return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
         );
     }
   public function toFeedItem(): FeedItem {}
   public function media() {
      return $this->belongsTo(Media::class,'media_id', 'id');
   }
    public function categories()
    {
       return $this->hasMany(Category::class);
    }

    public function children()
    {
       return $this->hasOne(Category::class, 'id', 'parent_id');
    }

    public function childrens()
    {
       return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function posts() {
        return $this->belongsToMany(Post::class);
    }

    public function getLinks($menuBuilder, $arrayDatas) {
      if($arrayDatas['user']->hasPermissionTo('create_categories') && $arrayDatas['features']['category']) {
          $menuBuilder->add( Link::to( $arrayDatas['multilang'] ? '/admin/categories?lang='. $arrayDatas['lang'] : '/admin/categories', '<i class="ni ni-single-copy-04"></i> '.__('admin.menuback.categories'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
          // $menuBuilder->add( Link::to( $multilang ? '/admin/tags?lang='.$lang : '/admin/tags', '<i class="ni ni-single-copy-04"></i> '.__('admin.tags.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
      }
   }
}
