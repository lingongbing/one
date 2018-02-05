<?php

namespace App\Http\Requests\Api\V1;

use Dingo\Api\Http\FormRequest;

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
	    switch ($this->method()) {
		    case 'POST':
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
			    break;
		    case 'PATCH':
			    return [
				    'name' => 'required|max:255',
				    'wechat' => 'required|max:255',
				    'avatar' => 'required|max:255',
				    'region' => 'required|max:255',
				    'address' => 'max:255',
				    'mobile' => 'regex:/^1[3456789]\d{9}$/'
			    ];
			    break;
	    }
    }
}
