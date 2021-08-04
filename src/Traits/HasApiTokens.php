<?php

namespace Ludows\Adminify\Traits;
use App\Models\ApiToken;
use Illuminate\Support\Str;

trait HasApiTokens
{
    public function createToken(string $name, array $abilities = []) {

        $m = new ApiToken();
        $c = get_site_key('restApi');

        $salt = Str::random(10);
        $secret = $c['secret'];

        $plainTextToken = $secret.$salt;

        $list = [
            'name' => $name,
            'user_id' => $this->id ?? null,
            'token' => hash('sha256', $plainTextToken),
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
    
    public function isExpiratedToken() {
        
    }
    public function verifyToken() {
        
    }
}