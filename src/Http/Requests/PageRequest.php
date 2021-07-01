<?php

namespace Ludows\Adminify\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
                'min:5'
            ]
        ];

        if($r->useMultilang && $r->is('api.*')) {
            $a['lang'] = [
                'required'
            ];
            $a['token'] = [
                'required'
            ];
        }

        return $a;
    }
}
