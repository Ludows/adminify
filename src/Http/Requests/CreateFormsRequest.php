<?php

namespace Ludows\Adminify\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFormsRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //@todo
        return [
            'model_class' => ['required'],
            'title' => ['required', 'unique:forms'],
            'user_id' => ['required'],
        ];
    }
}
