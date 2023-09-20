<?php

namespace Ludows\Adminify\Models;

use App\Adminify\Models\Media;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

use App\Adminify\Models\UserPreference;

use Ludows\Adminify\Models\ClassicUser;
use Spatie\Menu\Laravel\Link;


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

     /**
     * Default values for attributes
     * @var  array an array with attribute as key and default as value
     */
    protected $attributes = [
        'avatar' => NULL,
    ];

    public function getSearchResult() : SearchResult
    {
       $url = route('users.edit', ['user' => $this->id]);

        return new \Spatie\Searchable\SearchResult(
           $this,
           $this->name,
           $url
        );
    }

    public function getLinks($menuBuilder, $arrayDatas) {
        if($arrayDatas['user']->hasPermissionTo('create_users') && $arrayDatas['features']['user']) {
            $menuBuilder->add( Link::to( $arrayDatas['multilang'] ? '/admin/users?lang='. $arrayDatas['lang'] : '/admin/users', '<i class="ni ni-single-copy-04"></i> '.__('admin.menuback.users'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
            $menuBuilder->add('user_item', [
                'icon' => 'journal',
                'iconPrefix' => 'bi',
                'url' => $arrayDatas['multilang'] ? '/admin/users?lang='. $arrayDatas['lang'] : '/admin/users',
                'label' => __('admin.menuback.users'),
            ]);
        }
    }

    public function getPreference($type) {
        $pref = new UserPreference();
        $model = $pref->type($type)->userId($this->id)->get()->first();
        return $model->data ?? null;
    }

    public function preferences() {
        return $this->hasMany(UserPreference::class, 'user_id', 'id');
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
