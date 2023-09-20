<?php

namespace Ludows\Adminify\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTemplatesRequest extends FormRequest
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
        $a = [
            'title' => [
                'required',
                'string',
            ],
            'content' => [
                'required',
                'string',
            ],
        ];

        return $a;
    }
}
