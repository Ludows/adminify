<?php

namespace Ludows\Adminify\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMediaRequest extends FormRequest
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
            //
            'title' => [
                'required',
                'min:5'
            ],
            'src' => [
                'max:10000',
            ]
        ];

        return $a;
    }
}
