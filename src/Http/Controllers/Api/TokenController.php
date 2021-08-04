<?php

namespace Ludows\Adminify\Http\Controllers\Api;

use Ludows\Adminify\Http\Controllers\Controller;

use App\Http\Requests\TokenRequest;

use Illuminate\Http\Request;
use App\Models\User;

class TokenController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }
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
            $anonymous = $anonymous->find(User::GUEST);
            $token = $anonymous->getCurrentToken();
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