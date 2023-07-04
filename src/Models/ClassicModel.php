<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;

use Ludows\Adminify\Traits\AdminableMenu;
use Spatie\Translatable\HasTranslations;
use Ludows\Adminify\Traits\MultilangTranslatableSwitch;
use Ludows\Adminify\Traits\Helpers;
use Ludows\Adminify\Traits\Listable;
use Ludows\Adminify\Traits\Searchables;
use Ludows\Adminify\Traits\SavableTranslations;
use Ludows\Adminify\Traits\HasMeta;
use Ludows\Adminify\Traits\HasStatus;
use Ludows\Adminify\Traits\Hookable;
use Ludows\Adminify\Traits\QueryCachable;
use Ludows\Adminify\Traits\GenerateSlug;
use Ludows\Adminify\Traits\HasInteractsWithMediaLibrary;
use Ludows\Adminify\Traits\Commentable;
use Ludows\Adminify\Traits\HasUser;
use Ludows\Adminify\Traits\HasRevisions;
use Ludows\Adminify\Traits\HasSettings;
use Ludows\Adminify\Traits\HasCategoriesRelations;
use Ludows\Adminify\Traits\HasTagsRelations;

use Spatie\Feed\Feedable;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

use Ludows\Adminify\Libs\QueryCachableModule;

abstract class ClassicModel extends Model implements Searchable, Feedable
{
    use HasFactory;
    use HasMeta;
    use Hookable;
    use HasTranslations;
    use AdminableMenu;
    use MultilangTranslatableSwitch;
    // use Sitemapable;
    use Helpers;
    use Listable;
    use Searchables;
    use SavableTranslations;
    use HasStatus;
    use QueryCachable;
    use GenerateSlug;
    use Commentable;
    use HasInteractsWithMediaLibrary;
    use HasUser;
    use HasRevisions;
    use HasSettings;
    use HasCategoriesRelations;
    use HasTagsRelations;

    public function newEloquentBuilder($query)
    {
        return new QueryCachableModule($query);
    }

    public function getSearchResult() : SearchResult
    {
       $tableName = $this->getTable();

       $url = route( plural($tableName).'.edit', [ singular( $tableName ) => $this->id]);

        return new \Spatie\Searchable\SearchResult(
           $this,
           $this->{$this->searchable_label},
           $url
        );
    }

    public function shouldAppendAs($name = '', $attrName = '') {
        $filables = $this->getFillable();

        if(in_array($name, $filables)) {
            $this->appends[] = $attrName;
        }
    }
    public function addAppends($array = []) {
        if(is_array($array)) {
            foreach ($array as $key => $value) {
                # code...
                $this->addAppend($value);
            }
        }
    }
    public function addAppend($name = '') {
        $this->appends[] = $name;
        return $this;
    }

    public function __construct() {
        // dump($this->appends, $this->getFillable());
        parent::__construct();
        $this->registerMultilangSwitch();
        $this->shouldAppendAs( $this->status_key , 'status');
        $this->shouldAppendAs( $this->userOwnerKey, 'user' );
        $this->shouldAppendAs( 'categories_id' , 'categories' );
        $this->shouldAppendAs( $this->featured_column_media , 'media' );
    }

    public function defineCacheStrategy() {

        // dd('is_admin', is_admin());
        // we remove the cache in back end.
        return !is_admin();

    }
}
