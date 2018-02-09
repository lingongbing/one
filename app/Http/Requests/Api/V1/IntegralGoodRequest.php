<?php

namespace App\Http\Requests\Api\V1;

use Dingo\Api\Http\FormRequest;

class IntegralGoodRequest extends FormRequest
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
			'integral' => 'required|numeric|digits_between:1,10',
		];
	}
}
