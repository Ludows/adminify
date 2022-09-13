<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

use Ludows\Adminify\Traits\HasApiTokens;

use Ludows\Adminify\Traits\Helpers;
use Ludows\Adminify\Traits\Listable;
use Ludows\Adminify\Traits\Searchables;
use Ludows\Adminify\Traits\SavableTranslations;
use Ludows\Adminify\Traits\HasRevisions;

use App\Adminify\Models\ApiToken;
use App\Adminify\Models\Role;
use Ludows\Adminify\Traits\AdminableMenu;

abstract class ClassicAuthUser extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;
    use HasRoles;

    use HasFactory;
    use Helpers;
    use Listable;
    use Searchables;
    use SavableTranslations;
    use AdminableMenu;
    use HasRevisions;

    public $enable_revisions = false;

    public function tokens() {
        return $this->hasMany(ApiToken::class, 'user_id', 'id');
    }

    //@todo
    public function isGuest() {
        $r = $this->roles->pluck('id');
        return in_array(Role::GUEST, $r);
    }
    public function isAdmin() {
        $r = $this->roles->pluck('id');
        return in_array(Role::ADMINISTRATOR, $r);
    }
    public function isEditor() {
        $r = $this->roles->pluck('id');
        return in_array(Role::EDITOR, $r);
    }
    public function isSubscriber() {
        $r = $this->roles->pluck('id');
        return in_array(Role::SUBSCRIBER, $r);
    }
}
