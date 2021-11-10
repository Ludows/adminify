<?php

namespace Ludows\Adminify\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FormConfirmationRequest extends FormRequest
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
        $all = $r->all();

        if(!empty($all['type']) && $all['type'] == 'page') {
            $a = [
                'page_id' => ['required']
            ];
        }

        if(!empty($all['type']) && $all['type'] == 'redirect') {
            $a = [
                'redirect_url' => ['required']
            ];
        }

        if(!empty($all['type']) && $all['type'] == 'samepage') {
            $a = [
                'content' => ['required']
            ];
        }

        return $a;
    }
}
