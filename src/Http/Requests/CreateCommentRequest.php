<?php

namespace Ludows\Adminify\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCommentRequest extends FormRequest
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
            'comment' => ['required'],
            'parent_id' => ['required'],
            'model_id' => ['required'],
            'model_class' => ['required'],
            'user_id' => ['required'],
            'is_moderated' => ['required']
        ];
    }
}
