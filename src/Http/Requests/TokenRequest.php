<?php

namespace Ludows\Adminify\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TokenRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $r = request();

        $a = [
            'token' => [
                'required'
            ]
        ];

        if($r->useMultilang && $r->is('api.*')) {
            $a['lang'] = [
                'required'
            ];
        }

        return $a;
    }
}
