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
			'user_name' => $order->user(),
			'goods_name' => $order->good()
		];
	}
}