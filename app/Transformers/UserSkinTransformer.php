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
		];
	}
}