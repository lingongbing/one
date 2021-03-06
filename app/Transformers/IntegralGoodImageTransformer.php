<?php

namespace App\Transformers;

use App\Models\IntegralGoodImage;
use League\Fractal\TransformerAbstract;

class IntegralGoodImageTransformer extends TransformerAbstract
{
	public function transform(IntegralGoodImage $image)
	{
		return [
			'id' => $image->id,
			'image' => $image->image,
			'is_main' => $image->is_main
		];
	}
}