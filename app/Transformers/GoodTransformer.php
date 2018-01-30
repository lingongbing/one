<?php

namespace App\Transformers;

use App\Models\Good;
use League\Fractal\TransformerAbstract;

class GoodTransformer extends TransformerAbstract
{
	public function transform(Good $goods)
	{
		return [
			'id' => $goods->id,
			'name' => $goods->name,
			'image' => $goods->image
		];
	}
}