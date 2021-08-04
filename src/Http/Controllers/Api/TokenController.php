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
        $user = user(); // get logged user
        $lang = $datas['lang'] ?? lang();
        $config = get_site_key('restApi');
        $token = null;

        if($user == null) {
            $anonymous = new User();
            $token = $anonymous->createToken($config['token_name'])->token;
        }

        if($user != null && $user->tokenCan('api:full') && $user->hasAnyRole($config['roles_token_capacities'])) {
            $token = $user->getCurrentToken();
        }

        if($token == null) {
            abort(404, 'Token not found');
        }

        return response()->json([
            'token' => $token
        ]);
    }
}