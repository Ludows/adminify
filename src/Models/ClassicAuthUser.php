<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

use Laravel\Sanctum\HasApiTokens;

use Ludows\Adminify\Traits\OnBootedModel;
use Spatie\Translatable\HasTranslations;
use Ludows\Adminify\Traits\MultilangTranslatableSwitch;
use Ludows\Adminify\Traits\Helpers;
use Ludows\Adminify\Traits\Formidable;
use Ludows\Adminify\Traits\Listable;
use Ludows\Adminify\Traits\Searchables;

use Illuminate\Support\Facades\DB;


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

    public function getRolesAttribute() {
        $config = config('permissions.table_names.model_has_roles');
        $roleModel = app('Spatie\Permission\Models\Role');
        $pivotResults = DB::select('select * from '. $config .' where model_id = '. $this->id .'  and where model_name = App\Models\User');

        $a = collect();

        foreach ($pivotResults as $result) {
            # code...
            $a->push( $roleModel->find($result->role_id) );
        }

        return $a;
    }
}
