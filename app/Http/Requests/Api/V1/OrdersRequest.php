<?php

namespace App\Http\Requests\Api\V1;

use Dingo\Api\Http\FormRequest;

class OrdersRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'goods_id' => 'required|exists:goods,id',
            'goods_number' => 'required|numeric',
            'goods_total_price' => 'required|numeric',
            'courier_company' => 'required',
	        'courier_order_no' => 'required|numeric|unique:orders'
        ];
    }

	public function attributes()
	{
		return [
			'user_id' => '用户',
			'goods_id' => '商品',
			'goods_number' => '商品数量',
			'goods_total_price' => '商品价格',
			'courier_company' => '快递公司',
			'courier_order_no' => '快递单号'
		];
    }
}
