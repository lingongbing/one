<?php

namespace App\Http\Requests\Api\V1;

use Dingo\Api\Http\FormRequest;

class ShippingAddressRequest extends FormRequest
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
			'city' => 'required|max:255',
			'area' => 'required|max:255',
			'phone' => 'required|max:255',
			'address' => 'required|max:255',
			'province' => 'required|max:255',
		];
	}
}
