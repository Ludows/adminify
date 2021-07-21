<?php

namespace Ludows\Adminify\Models;

use Illuminate\Support\Facades\Artisan;
use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

use Ludows\Adminify\Models\ClassicModel;
class Translations extends ClassicModel
{
    public $MultilangTranslatableSwitch = ['text'];

    protected $table = 'traductions';

    protected $fillable = [
        'key',
        'text'
    ];

    public function scopeKey($query, $key) {
        return $query->where('key', $key);
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
