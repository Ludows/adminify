<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;

// use Ludows\Adminify\Traits\OnBootedModel;
use Ludows\Adminify\Traits\AdminableMenu;
use Spatie\Translatable\HasTranslations;
use Ludows\Adminify\Traits\MultilangTranslatableSwitch;
use Ludows\Adminify\Traits\Helpers;
use Ludows\Adminify\Traits\Formidable;
use Ludows\Adminify\Traits\Listable;
use Ludows\Adminify\Traits\Searchables;
use Ludows\Adminify\Traits\SavableTranslations;
use Ludows\Adminify\Traits\PathableMedia;
use Ludows\Adminify\Traits\ProcessableAssets;
use Ludows\Adminify\Traits\HasMeta;
use Ludows\Adminify\Traits\HasStatus;
use Ludows\Adminify\Traits\Hookable;
use Ludows\Adminify\Traits\QueryCachable;
use Ludows\Adminify\Traits\GenerateSlug;

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
    // use OnBootedModel;
    // use Urlable;
    use HasTranslations;
    use AdminableMenu;
    use MultilangTranslatableSwitch;
    use PathableMedia;
    // use Sitemapable;
    use Helpers;
    use Formidable;
    use Listable;
    use Searchables;
    use SavableTranslations;
    use ProcessableAssets;
    use HasStatus;
    use QueryCachable;
    use GenerateSlug;
    // use QueryCacheable;

    // public $cacheFor = 3600;

    // public $cacheDriver = 'file';

    // protected static $flushCacheOnUpdate = true;

    // public function __construct() {
    //     parent::__construct();
    //     $this->useSaveRelations = false;
    // }

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

    public function defineCacheStrategy() {

        // dd('is_admin', is_admin());
        // we remove the cache in back end.
        return !is_admin();

    }

    // /**
    //  * The tags for the query cache. Can be useful
    //  * if flushing cache for specific tags only.
    //  *
    //  * @return null|array
    //  */
    // protected function cacheTagsValue()
    // {
    //     $tableName = $this->getTable();

    //     return [ plural($tableName) ];
    // }

    // /**
    //  * A cache prefix string that will be prefixed
    //  * on each cache key generation.
    //  *
    //  * @return string
    //  */
    // protected function cachePrefixValue()
    // {
    //     $tableName = $this->getTable();

    //     return  plural($tableName).'_';
    // }

    // protected function cacheForValue()
    // {
    //     if (is_admin()) {
    //         return null;
    //     }

    //     return $this->cacheFor;
    // }
}
