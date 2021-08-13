<?php

namespace Ludows\Adminify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\User;

class VerifyAbilitiesToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $abilities)
    {
        //the token is valid we check now the abilities attached
        $u = user();

        if($u == null) {
            //fallback to guest user
            $u = User::find(Role::GUEST);
        }

        $role = $u->roles->first();
        
        $abilities = $abilities != null ? explode('|', $abilities) : get_site_key('restApi.token_capacities.'.$role->name);

        $abilities_user = $u->getCurrentAbilities();

        if(!in_array($abilities, $abilities_user)) {
            abort(403);
        }

        return $next($request);
    }
}
