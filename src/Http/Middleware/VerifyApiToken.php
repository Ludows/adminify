<?php

namespace Ludows\Adminify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\Role;

class VerifyApiToken
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

        $token = $request->get('token');
        $user = user();

        if($user == null) {
            //fallback to guest user
            $user = User::find(Role::GUEST);
        }

        if($token == null) {
            abort(403);
        }

        if($token != null) {
            $isValidToken = $user->verifyToken($token);

            if($isValidToken == false) {
                abort(403);
            }

        }


        return $next($request);
    }
}
