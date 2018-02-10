<?php

namespace App\Http\Requests\Api\V1;

use Dingo\Api\Http\FormRequest;

class IntegralOrderRequest extends FormRequest
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
					'integral_good_id' => 'required|exists:integral_goods,id',
					'number' => 'required|numeric|integer',
					'consignee' => 'required|max:255',
					'phone' => 'required|regex:/^1[34578]\d{9}$/',
					'province' => 'required|max:255',
					'city' => 'required|max:255',
					'area' => 'required|max:255',
					'address' => 'required|max:255'
				];
				break;
			case 'PATCH':
				return [
					'courier_order_no' => 'required|numeric'
				];
				break;
		}
	}

	public function attributes()
	{
		return [
			'integral_good_id' => '商品',
			'number' => '数量',
			'phone' => '手机',
			'consignee' => '收货地址',
			'province' => '收货地址',
			'city' => '收货地址',
			'area' => '收货地址',
			'address' => '收货地址',
			'courier_order_no' => '快递单号'
		];
	}
}
