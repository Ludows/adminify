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

    protected $fillable = [
        'key',
        'text'
    ];

    public function scopeKey($query, $key) {
        return $query->where('key', $key);
    }

    public function getTableListing() {
        return \Ludows\Adminify\Tables\TranslationTable::class;
    }

    public function getLinks($menuBuilder, $arrayDatas) {
        if($arrayDatas['user']->hasPermissionTo('create_translations')) {
            $menuBuilder->add( Link::to( $arrayDatas['multilang'] ? '/admin/traductions?lang='. $arrayDatas['lang'] : '/admin/traductions', '<i class="ni ni-single-copy-04"></i> '.__('admin.menuback.traductions'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
        }
    }

    public $excludes_savables_fields = [];
    public $unmodified_savables_fields = [];
    public function getSavableForm() {
        return \App\Forms\UpdateTranslation::class;
    }

    protected static function makeTranslations($context) {

        Artisan::call('generate:translations', [
            '--front' => true
        ]);

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

    protected static function booted()
    {
        static::created(function ($model) {
            //
            static::makeTranslations($model);
        });
        static::updated(function ($model) {
            //
            static::makeTranslations($model);
        });
        static::deleted(function ($model) {
            //
            static::makeTranslations($model);
        });
    }
}
