<?php

namespace App\Transformers;

use App\Models\ShippingAddress;
use League\Fractal\TransformerAbstract;

class ShippingAddressTransformer extends TransformerAbstract
{
	public function transform(ShippingAddress $shippingAddress)
	{
		return [
			'id' => $shippingAddress->id,
			'name' => $shippingAddress->name,
			'phone' => $shippingAddress->phone,
			'province' => $shippingAddress->province,
			'city' => $shippingAddress->city,
			'area' => $shippingAddress->area,
			'address' => $shippingAddress->address
		];
	}
}