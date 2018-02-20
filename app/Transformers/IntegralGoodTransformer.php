<?php

namespace App\Transformers;

use App\Models\IntegralGood;
use League\Fractal\TransformerAbstract;

class IntegralGoodTransformer extends TransformerAbstract
{
	public function transform(IntegralGood $good)
	{
		return [
			'id' => $good->id,
			'name' => $good->name,
			'images' => $good->image,
			'integral' => $good->integral,
			'description' => $good->description,
			'introduction' => $good->introduction,
			'reference_price' => $good->reference_price
		];
	}
}