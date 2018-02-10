<?php

namespace App\Transformers;

use App\Models\IntegralOrder;
use League\Fractal\TransformerAbstract;

class IntegralOrderTransformer extends TransformerAbstract
{
	public function transform(IntegralOrder $order)
	{
		return [
			'id' => $order->id,
			'user' => $order->user,
			'good' => $order->good,
			'number' => $order->number,
			'integral' => $order->integral,
			'consignee' => $order->consignee,
			'phone' => $order->phone,
			'province' => $order->province,
			'city' => $order->city,
			'area' => $order->area,
			'address' => $order->address,
			'created_at' => $order->created_at->toDateTimeString(),
			'updated_at' => $order->updated_at->toDateTimeString(),
			'state' => $order->state,
			'courier_order_no' => $order->courier_order_no
		];
	}
}