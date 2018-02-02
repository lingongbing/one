<?php

namespace App\Transformers;

use App\Models\SkinBelong;
use League\Fractal\TransformerAbstract;

class SkinBelongTransformer extends TransformerAbstract
{
	public function transform(SkinBelong $skinBelong)
	{
		return [
			'id' => $skinBelong->id,
			'name' => $skinBelong->name,
		];
	}
}