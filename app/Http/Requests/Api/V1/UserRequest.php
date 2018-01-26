<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
	        'username' => 'required|string|max:255|unique:users',
	        'password' => 'required|string',
	        'verification_key' => 'required|string',
	        'verification_code' => 'required|string',
        ];
    }

	public function attributes()
	{
		return [
			'verification_key' => '短信验证码 key',
			'verification_code' => '短信验证码',
		];
	}
}
