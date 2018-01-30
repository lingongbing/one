<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
	public function transform(User $user)
	{
		return [
			'id' => $user->id,
			'name' => $user->name,
			'role' => count($user->getRoleNames()) ? $user->getRoleNames()[0] : false,
			'avatar' => $user->avatar,
			'username' => $user->username,
			'created_at' => $user->created_at,
			'updated_at' => $user->updated_at,
		];
	}
}