<?php

namespace Ludows\Adminify\Models;

use Ludows\Adminify\Models\ClassicModel;
use Spatie\Feed\FeedItem;
use Spatie\Searchable\SearchResult;
use Spatie\Menu\Laravel\Link;

use App\Adminify\Models\FormField;
use App\Adminify\Models\FormTrace;
use App\Adminify\Models\FormConfirmations;

class Forms extends ClassicModel
{
    protected $table = 'forms';

    public $MultilangTranslatableSwitch = ['title'];

    public $searchable_label = 'title';

    protected $fillable = [
        'title',
        'slug',
        'user_id',
        'model_class'
    ];

    public function getAdminifyAliases() {
        return [
            'form', 'formidables', 'formidable'
        ];
    }

    public function user() {
        return $this->HasOne(User::class, 'id', 'user_id');
    }

    /**
     * Default values for attributes
     * @var  array an array with attribute as key and default as value
     */
    protected $attributes = [];

    public function fields()
    {
        return $this->belongsToMany(FormField::class, 'form_form_field', 'form_id')->orderBy('order','asc')->withPivot('order');
    }

    public function confirmation()
    {
        return $this->belongsToMany(FormConfirmations::class, 'form_form_confirmation', 'form_id');
    }

    public function traces()
    {
        return $this->hasMany(FormTrace::class, 'form_id');
    }

    public function toFeedItem(): FeedItem {}

    public function getLinks($menuBuilder, $arrayDatas) {
        if($arrayDatas['user']->hasPermissionTo('create_forms') && $arrayDatas['features']['form']) {
            $menuBuilder->add( Link::to( $arrayDatas['multilang'] ? '/admin/forms?lang='. $arrayDatas['lang'] : '/admin/forms', '<i class="ni ni-image"></i> '.__('admin.menuback.forms'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
            // $menuBuilder->add( Link::to( $multilang ? '/admin/tags?lang='.$lang : '/admin/tags', '<i class="ni ni-single-copy-04"></i> '.__('admin.tags.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
        }
    }
}
