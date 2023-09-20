<?php

namespace Ludows\Adminify\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
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
            'name' => [
                'required',
            ],
            'email' => [
                'email' ,'unique:users,email',
            ],
            'password' => [
                'required',
            ],
        ];

        return $a;
    }
}
