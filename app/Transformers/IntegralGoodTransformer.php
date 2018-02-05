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
			'integral' => $good->integral,
			'introduction' => $good->introduction
		];
	}
}