<?php

namespace Ludows\Adminify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Adminify\Models\Role;
use App\Adminify\Models\User;

class VerifyAbilitiesToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //the token is valid we check now the abilities attached
        $u = user();

        $role = $u->roles->first();

        $abilities = get_site_key('restApi.token_capacities.'.$role->name);


        $abilities_user = $u->getCurrentAbilities();

        if(!array_equal($abilities, $abilities_user)) {
            abort(403);
        }

        return $next($request);
    }
}
