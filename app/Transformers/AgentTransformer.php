<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class AgentTransformer extends TransformerAbstract
{
	public function transform(User $user)
	{
		return [
			'id' => $user->id,
			'name' => $user->name,
			'level' => $user->level,
			'mobile' => $user->mobile,
			'wechat' => $user->wechat,
			'username' => $user->username,
			'introduction' => $user->introduction,
		];
	}
}