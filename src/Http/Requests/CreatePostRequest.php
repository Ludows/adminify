<?php

namespace Ludows\Adminify\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $a = [
            'title' => [
                'required',
            ],
            'status_id' => [
                'required'
            ]
        ];

        return $a;
    }
}
