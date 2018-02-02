<?php

namespace App\Http\Requests\Api\V1;

use Dingo\Api\Http\FormRequest;

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
        switch ($this->method()) {
	        case 'POST':
		        return [
			        'username' => 'required|string|max:255|unique:users',
			        'password' => 'required|string',
			        'verification_key' => 'required|string',
			        'verification_code' => 'required|string',
		        ];
		        break;
	        case 'PATCH':
	        	return [
	        		'mobile' => 'regex:/^1[3456789]\d{9}$/|unique:users',
	        		'password' => 'string|min:6',
		        ];
	        	break;
        }
    }

	public function attributes()
	{
		return [
			'verification_key' => '短信验证码 key',
			'verification_code' => '短信验证码',
		];
	}
}
