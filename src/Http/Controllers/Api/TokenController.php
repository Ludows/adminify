<?php

namespace Ludows\Adminify\Http\Controllers\Api;

use Ludows\Adminify\Http\Controllers\Controller;

use App\Http\Requests\TokenRequest;

use Illuminate\Http\Request;
use App\Models\User;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getToken(Request $request)
    {
        $datas = $request->all();
        $user = user();
        $lang = $datas['lang'] ?? lang();
        $config = get_site_key('restApi');
        $role = $user->roles->first();

        if($user == null) {
            abort(403);
        }

        if($user != null && $user->tokenCan('api:full') && $user->hasAnyRoles($config['roles_token_capacities'][$role->name])) {

            return response()->json([
                'token' => $user->currentAccessToken()
            ]);
            
        }
        else {
            abort(404, 'Token not found');
        }
    }
}