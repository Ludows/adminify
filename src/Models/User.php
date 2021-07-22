<?php

namespace Ludows\Adminify\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Media;

use Spatie\Searchable\Searchable;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

use Ludows\Adminify\Models\ClassicModel;

use Ludows\Adminify\Traits\Listable;
use Ludows\Adminify\Traits\Helpers;
use Ludows\Adminify\Traits\Searchables;
class User extends Authenticatable implements ClassicModel
{
    use HasFactory, Notifiable, HasApiTokens;
    use HasRoles;

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
