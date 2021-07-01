<?php

namespace Ludows\Adminify\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTranslation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $r = request();
        $a = [
            'key' => [
                'unique:traductions,key',
                'required',
                'string'
            ],
            'text' => [
                'required',
                'string'
            ]
        ];

        if($r->is('api.*')) {
            $a['token'] = [
                'required'
            ];
        }

        if($r->useMultilang && $r->is('api.*')) {
            $a['lang'] = [
                'required'
            ];
        }

        return $a;
    }
}
