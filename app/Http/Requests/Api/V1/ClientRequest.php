<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        	'name' => 'required|max:255',
			'wechat' => 'required|max:255',
			'mobile' => 'required|regex:/^1[3456789]\d{9}$/|unique:users',
			'avatar' => 'required|max:255',
			'region' => 'required|max:255',
			'address' => 'required|max:255',
			'username' => 'required|max:255|unique:users',
			'password' => 'required'
        ];
    }
}
