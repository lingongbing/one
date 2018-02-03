<?php

namespace App\Transformers;

use App\Models\UserSkin;
use League\Fractal\TransformerAbstract;

class UserSkinTransformer extends TransformerAbstract
{
	public function transform(UserSkin $skin)
	{
		return [
			'id' => $skin->id,
			'condition' => $skin->condition,
			'check_time' => date('Y-m-d',strtotime($skin->check_time)),
			'makeup_habits' => $skin->makeup_habits,
			'skin_belong_id' => $skin->skin_belong_id,
			'nursing_advice' => $skin->nursing_advice,
			'skin_category_id' => $skin->skin_category_id,
			'characteristics' => $skin->characteristics,
			'commonly_products' => $skin->commonly_products,
			'skin_belong' => $skin->skin_belong->name,
			'skin_category' => $skin->skin_category->name,
		];
	}
}