<?php

namespace App\Transformers;

use App\Models\Order;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
	public function transform(Order $order)
	{
		return [
			'id' => $order->id,
			'name' => $order->user->name ? $order->user->name : $order->user->username,
			'order_no' => $order->order_no,
			'goods_name' => $order->good && $order->good->name ? $order->good->name : '商品不存在',
			'courier_order_no' => $order->courier_order_no,
			'goods_number' => $order->goods_number,
			'goods_total_price' => $order->goods_total_price,
			'courier_company' => $order->courier_company,
			'created_at' => $order->created_at->format('Y-m-d H:i:s'),
			'goods_image' => $order->good && $order->good->image ? $order->good->image : '',
			'state' => $order->state
		];
	}
}