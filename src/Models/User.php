<?php

namespace Ludows\Adminify\Models;

use App\Models\Media;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

use Ludows\Adminify\Models\ClassicUser;

class User extends ClassicUser
{    
    public $searchable_label = 'name';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar',
        'name',
        'email',
        'password',
    ];

    public function getTableListing() {
        return \Ludows\Adminify\Tables\UserTable::class;
    }

    public function getSearchResult() : SearchResult
    {
       $url = route('users.edit', ['user' => $this->id]);

        return new \Spatie\Searchable\SearchResult(
           $this,
           $this->name,
           $url
        );
    }

    public function toFeedItem(): FeedItem {}

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function avatar() {
        return $this->hasOne(Media::class, 'id', 'avatar');
    }
}
