<?php

namespace Ludows\Adminify\Http\Requests;

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

        return $a;
    }
}
