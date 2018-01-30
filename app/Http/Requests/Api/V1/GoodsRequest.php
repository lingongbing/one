<?php

namespace App\Http\Requests\Api\V1;

use Dingo\Api\Http\FormRequest;

class GoodsRequest extends FormRequest
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
	        'name' => 'required|string|max:255',
	        'image' => 'required|string|max:255'
        ];
    }

	public function attributes()
	{
		return [
			'image' => '图片'
		];
    }
}
