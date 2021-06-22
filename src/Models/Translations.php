<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Ludows\Adminify\Traits\MultilangTranslatableSwitch;
use Illuminate\Support\Facades\Artisan;
use Ludows\Adminify\Traits\Helpers;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
class Traduction extends Model implements Searchable
{
    use HasFactory;
    use HasTranslations;
    use Helpers;
    use MultilangTranslatableSwitch;
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

    public function getSearchResult(): SearchResult
    {
       $url = route('traductions.edit', ['traduction' => $this->id]);

        return new \Spatie\Searchable\SearchResult(
           $this,
           $this->key,
           $url
        );
    }

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
