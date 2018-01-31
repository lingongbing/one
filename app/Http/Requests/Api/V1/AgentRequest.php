<?php

namespace App\Http\Requests\Api\V1;

use Dingo\Api\Http\FormRequest;

class AgentRequest extends FormRequest
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
				    'name' => 'required|string|max:255',
				    'wechat' => 'required|string|max:255',
				    'username' => 'required|string|unique:users|max:255',
				    'mobile' => 'required|regex:/^1[34578]\d{9}$/|unique:users',
				    'password' => 'required|string|min:6',
				    'introduction' => 'required|string|max:255',
				    'level' => 'required|string|max:255',
				    'avatar' => 'required|string|max:255',
			    ];
			    break;
		    case 'PATCH':
			    return [
				    'name' => 'required|string|max:255',
				    'wechat' => 'required|string|max:255',
				    'password' => 'string|min:6',
				    'introduction' => 'required|string|max:255',
				    'level' => 'required|string|max:255',
				    'avatar' => 'required|string|max:255',
			    ];
			    break;
	    }
    }
}
