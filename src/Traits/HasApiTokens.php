<?php

namespace Ludows\Adminify\Traits;
use App\Models\ApiToken;
use Illuminate\Support\Str;

use Carbon\Carbon;

trait HasApiTokens
{
    public function generateToken() {
        $c = get_site_key('restApi');
        $salt = Str::random(10);
        $secret = $c['secret'];

        $plainTextToken = $secret.$salt;

        return hash('sha256', $plainTextToken);
    }
    public function createToken(string $name, array $abilities = []) {

        $m = new ApiToken();
        $c = get_site_key('restApi');

        $plainTextToken = $this->generateToken();

        $list = [
            'name' => $name,
            'user_id' => $this->id ?? null,
            'token' => $plainTextToken,
            'abilities' => join(',', $abilities),
            'expiration_date' => $c['expiration_time'],
            'ip_adress' => request()->ip()
        ];

        foreach ($list as $keyL => $value) {
            # code...
            $m->{$keyL} = $value;
        }

        $m = $m->save();

        return $m;
    }

    public function getCurrentToken() {
        return $this->tokens()->first();
    }
    public function getCurrentAbilities() {
        $abilities = $this->getCurrentToken()->abilities;
        return explode(',', $abilities); 
    }

    public function delete() {

    }

    public function tokenCan($abilities) {
        $tokenCan = false;
        $tokenUserModel = $this->getCurrentToken();
        $abilities_user = explode(',', $tokenUserModel->abilities);
        if(in_array($abilities, $abilities_user)) {
            $tokenCan = true;
        }
        return $tokenCan;
    }
    
    public function isExpiratedToken($token) {
        $isExpirated = false;

        $c = get_site_key('restApi');
        $isEnabled = $c['expiration_time'] != null;

        if($isEnabled) {
            // check time
            $now = Carbon::now();
            $dateToken = Carbon::parse($token->expiration_date);

            if($now->gt($dateToken)) {
                $isExpirated = true;
            }
        }


        return $isExpirated;
    }
    public function refreshToken() {

        $tokenUserModel = $this->getCurrentToken();
        $plainTextToken = $this->generateToken();

        $tokenUserModel->fill([
            "token" => $plainTextToken
        ]);

        $tokenUserModel->save();

        return $tokenUserModel;
    }
    public function verifyToken(string $token) {
        $verify = false;
        $tokenUserModel = $this->getCurrentToken();
        $tokenFromUser = $tokenUserModel->token;
        if($tokenFromUser === $token) {
            //première passe okay
            // Maintenant on teste la validité du token
            $isExpirated = $this->isExpiratedToken($tokenUserModel);
            if(!$isExpirated) {
                $verify = true;
            }
        }
        return $verify;
    }
}
