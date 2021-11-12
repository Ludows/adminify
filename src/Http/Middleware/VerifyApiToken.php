<?php

namespace Ludows\Adminify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Adminify\Models\Role;
use App\Adminify\Models\User;

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
