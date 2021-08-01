<?php

namespace Ludows\Adminify\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTagRequest extends FormRequest
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
        $r = request();
        
        $routeName = request()->route()->getName();
        if($routeName == 'tags.update') {
            $a = [
                'title' => [
                    'required',
                    'string'
                ],
            ];
        }
        else {
            $a = [
                'title' => [
                    'unique:tags,title',
                    'required',
                    'string',
                ],
            ];
        }
        

        if($r->is('api.*')) {
            $a['token'] = [
                'required'
            ];
        }

        if($r->useMultilang && $r->is('api.*')) {
            $a['lang'] = [
                'required'
            ];
        }

        return $a;
    }
}
