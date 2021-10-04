<?php

namespace Ludows\Adminify\Models;

use Spatie\Searchable\SearchResult;

use Ludows\Adminify\Models\ContentTypeModel;
use Spatie\Menu\Laravel\Link;

class Page extends ContentTypeModel
{
    public $MultilangTranslatableSwitch = ['title', 'slug', 'content'];

    public function getLinks($menuBuilder, $arrayDatas) {
        if($arrayDatas['user']->hasPermissionTo('create_pages') && $arrayDatas['features']['page']) {
            $menuBuilder->add( Link::to( $arrayDatas['multilang'] ? '/admin/pages?lang='. $arrayDatas['lang'] : '/admin/pages', '<i class="ni ni-single-copy-04"></i> '.__('admin.menuback.pages'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
            // $menuBuilder->add( Link::to( $multilang ? '/admin/tags?lang='.$lang : '/admin/tags', '<i class="ni ni-single-copy-04"></i> '.__('admin.tags.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
        }
    }

    public function getTableListing() {
        return \App\Adminify\Tables\PageTable::class;
    }

    public $excludes_savables_fields = [
        'media_id',
        'parent_id',
        'status_id'
    ];
    
    public $unmodified_savables_fields = [
        'content',
        'categories_id',
        'user_id',
        'submit'
    ];

    public function getSavableForm() {
        return \App\Adminify\Forms\CreatePage::class;
    }

    protected $fillable = [
        'title',
        'slug',
        'content',
        'media_id',
        'parent_id',
        'user_id',
        'status_id'
    ];

    /**
     * Default values for attributes
     * @var  array an array with attribute as key and default as value
     */
    protected $attributes = [
        'content' => NULL,
        'media_id' => NULL,
        'parent_id' => 0,
        'user_id' => 0,
    ];


    public function media()
    {
        return $this->belongsTo(Media::class,'media_id', 'id');
    }
    public function categories()
    {
       return $this->belongsToMany(Category::class);
    }
}
