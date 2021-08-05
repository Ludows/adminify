<?php

namespace Ludows\Adminify\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMediaRequest extends FormRequest
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
            ],
            'src' => [
                'required',
            ]
        ];

        return $a;
    }
}
