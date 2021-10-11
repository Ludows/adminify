<?php

namespace Ludows\Adminify\Models;

use Ludows\Adminify\Models\ClassicModel;
use Spatie\Feed\FeedItem;
use Spatie\Searchable\SearchResult;
use Spatie\Menu\Laravel\Link;

use APp\Adminify\Models\Forms;

class FormField extends ClassicModel
{
    protected $table = 'form_fields';

    public $MultilangTranslatableSwitch = ['label'];

    public $sitemapCallable = 'title';

    public $enable_searchable = false;

    protected $fillable = [
        'label',
        'required',
        'max_length',
        'label_show',
        'label_attr',
        'attr',
        'wrapper',
    ];
    
    /**
     * Default values for attributes
     * @var  array an array with attribute as key and default as value
     */
    protected $attributes = [];

    public function getTableListing() {
        return null;
    }

    public function form()
    {
        return $this->belongsTo(Forms::class);
    }

    public function toFeedItem(): FeedItem {}

    // public function getLinks($menuBuilder, $arrayDatas) {
    //     if($arrayDatas['user']->hasPermissionTo('create_forms') && $arrayDatas['features']['form']) {
    //         $menuBuilder->add( Link::to( $arrayDatas['multilang'] ? '/admin/forms?lang='. $arrayDatas['lang'] : '/admin/forms', '<i class="ni ni-image"></i> '.__('admin.menuback.forms'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
    //         // $menuBuilder->add( Link::to( $multilang ? '/admin/tags?lang='.$lang : '/admin/tags', '<i class="ni ni-single-copy-04"></i> '.__('admin.tags.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
    //     }
    // }
}
