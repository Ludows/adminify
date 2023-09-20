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
            $menuBuilder->add('page_item', [
                'icon' => 'journal',
                'iconPrefix' => 'bi',
                'url' => $arrayDatas['multilang'] ? '/admin/pages?lang='. $arrayDatas['lang'] : '/admin/pages',
                'label' => __('admin.menuback.pages'),
            ]);
            // $menuBuilder->add( Link::to( $multilang ? '/admin/tags?lang='.$lang : '/admin/tags', '<i class="ni ni-single-copy-04"></i> '.__('admin.tags.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
        }
    }

    public $excludes_savables_fields = [
        'media_id',
        'parent_id',
        'status_id'
    ];
    
    public $unmodified_savables_fields = [
        'content',
        'categories',
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
}
