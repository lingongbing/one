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
			'level' => $user->level,
			'avatar' => $user->avatar,
			'wechat' => $user->wechat,
			'mobile' => $user->mobile,
			'region' => $user->region,
			'address' => $user->address,
			'username' => $user->username,
			'integral' => $user->integral,
			'created_at' => $user->created_at->format('Y-m-d H:i:s'),
			'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
			'introduction' => $user->introduction,
			'home_management' => $user->hasRole('home_management') ? true : false
		];
	}
}