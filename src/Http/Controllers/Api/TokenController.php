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
        $lang = $datas['lang'] ?? lang();
        $u = new User();
        $token = null;
        $config = config('site-settings.restApi');

        if($datas['user'] == null) {

            $token = $u->createToken( $config['token_name'], $config['token_capacities']['guest'] )->plainTextToken;
        }
        else {
            //RETRIEVE USER
            $u = $u->find($datas['user']->id);
            $token = $u->createToken( $config['token_name'], $config['token_capacities']['authentificated'] )->plainTextToken;
        }

        //token is setted in session
        session([$config['token_name'] => $token]);

        return response()->json([
            'token' => $token
        ]);
    }
}