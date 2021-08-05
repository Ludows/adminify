<?php

namespace Ludows\Adminify\Http\Controllers\Api;

use Ludows\Adminify\Http\Controllers\Controller;

use App\Http\Requests\TokenRequest;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->middleware(function ($request, $next) {
            $u = user();
            $this->user = $u != null ? $u : User::find(Role::GUEST);
    
            return $next($request);
        });
    }

    public function getToken(Request $request)
    {
        $datas = $request->all();
        $lang = $datas['lang'] ?? lang();
        $config = get_site_key('restApi');
        $token = $this->user->getCurrentToken()->token;

        if($token == null) {
            abort(404, 'Token not found');
        }

        return response()->json([
            'token' => $token
        ]);
    }
    public function verifyToken(Request $request) {
        $token = $request->get('token');

        // if true , is valid.
        // if false, you must send a request to get token;
        $isValid = $this->user->verifyToken($token);
        return response()->json([
            'isValid' => $isValid
        ]);
    }
    public function refreshToken(Request $request) {

        $refreshedToken = $this->user->refreshToken();
        
        return response()->json([
            'token' => $refreshedToken->token
        ]);
    }
}