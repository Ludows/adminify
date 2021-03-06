<?php

namespace Ludows\Adminify\Models;

use Illuminate\Support\Facades\Artisan;
use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

use Ludows\Adminify\Models\ClassicModel;
use Spatie\Menu\Laravel\Link;

class Translations extends ClassicModel
{
    public $MultilangTranslatableSwitch = ['text'];

    protected $table = 'traductions';

    public $searchable_label = 'key';

    protected $useSlugGeneration = false;

    protected $fillable = [
        'key',
        'text'
    ];

    public function getAdminifyAliases() {
        return [
            'translation', 'translations', 'traduction', 'traductions'
        ];
    }

    public function scopeKey($query, $key) {
        return $query->where('key', $key);
    }

    public $enable_searchable = true;

    public function getLinks($menuBuilder, $arrayDatas) {
        if($arrayDatas['user']->hasPermissionTo('create_translations') && $arrayDatas['features']['key_translation']) {
            $menuBuilder->add( Link::to( $arrayDatas['multilang'] ? '/admin/traductions?lang='. $arrayDatas['lang'] : '/admin/traductions', '<i class="ni ni-single-copy-04"></i> '.__('admin.menuback.traductions'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
        }
    }

    public $excludes_savables_fields = [];
    public $unmodified_savables_fields = [];
    public function getSavableForm() {
        return \App\Adminify\Forms\UpdateTranslation::class;
    }

    public function getSearchResult() : SearchResult
    {
       $url = route('traductions.edit', ['traduction' => $this->id]);

        return new \Spatie\Searchable\SearchResult(
           $this,
           $this->key,
           $url
        );
    }

    public function toFeedItem(): FeedItem {}
}
