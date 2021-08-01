<?php

namespace Ludows\Adminify\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
            'title' => [
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
