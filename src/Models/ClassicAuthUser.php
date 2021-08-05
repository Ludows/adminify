<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

use Ludows\Adminify\Traits\HasApiTokens;

use Ludows\Adminify\Traits\OnBootedModel;
use Spatie\Translatable\HasTranslations;
use Ludows\Adminify\Traits\MultilangTranslatableSwitch;
use Ludows\Adminify\Traits\Helpers;
use Ludows\Adminify\Traits\Formidable;
use Ludows\Adminify\Traits\Listable;
use Ludows\Adminify\Traits\Searchables;
use Ludows\Adminify\Traits\SavableTranslations;

use Illuminate\Support\Facades\DB;

use App\Models\ApiToken;
use App\Models\Role;

abstract class ClassicAuthUser extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;
    use HasRoles;

    use HasFactory;
    //use OnBootedModel;
    // use Urlable;
    //use HasTranslations;
    //use MultilangTranslatableSwitch;
    // use Sitemapable;
    use Helpers;
    use Formidable;
    use Listable;
    use Searchables;
    use SavableTranslations;

    public function tokens() {
        return $this->hasMany(ApiToken::class, 'user_id', 'id');
    }

    //@todo
    public function isGuest() {
        return $this->id === Role::GUEST;
    }
    public function isAdmin() {
        return $this->id === Role::ADMINISTRATOR;
    }
    public function isEditor() {
        return $this->id === Role::EDITOR;
    }
    public function isSubscriber() {
        return $this->id === Role::SUBSCRIBER;
    }
}
