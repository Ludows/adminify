<?php

namespace Ludows\Adminify\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGroupMetas extends FormRequest
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
            ],
            'named_class' => [
                'required'
            ],
            'user_id' => [
                'required'
            ]
        ];

        return $a;
    }
}
