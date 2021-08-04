<?php

namespace Ludows\Adminify\Traits;
use App\Models\ApiToken;
use Illuminate\Support\Str;

trait HasApiTokens
{
    public function createToken($name, array $abilities = []) {

        $m = new ApiToken();
        $c = get_site_key('restApi');

        $salt = Str::random(10);
        $secret = $c['secret'];

        $plainTextToken = $secret.$salt;

        $m = $m->create([
            'name' => $name,
            'user_id' => $this->id ?? null,
            'token' => hash('sha256', $plainTextToken),
            'abilities' => join(',', $abilities),
            'expiration_date' => $c['expiration_time'],
            'ip_adress' => request()->ip()
        ]);

        return $m;
    }
    
    public function isExpiratedToken() {
        
    }
    public function verifyToken() {
        
    }
}
