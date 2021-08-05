<?php

namespace Ludows\Adminify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\User;

class ShareCurrentUser
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

        $user = user();

        if($user == null) {
            $user = User::find(Role::GUEST);
        }

        view()->share('user', $user);

        return $next($request);
    }
}
