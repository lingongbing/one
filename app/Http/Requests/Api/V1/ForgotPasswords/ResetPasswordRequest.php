<?php

namespace App\Http\Requests\Api\V1\ForgotPasswords;

use Dingo\Api\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'password' => 'required|min:6',
            'verification_key' => 'required',
            'verification_code' => 'required',
        ];
    }

	public function attributes()
	{
		return [
			'verification_key' => '验证码',
			'verification_code' => '验证码',
		];
    }
}
