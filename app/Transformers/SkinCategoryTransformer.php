<?php

namespace App\Transformers;

use App\Models\SkinCategory;
use League\Fractal\TransformerAbstract;

class SkinCategoryTransformer extends TransformerAbstract
{
	public function transform(SkinCategory $skinCategory)
	{
		return [
			'id' => $skinCategory->id,
			'name' => $skinCategory->name,
		];
	}
}