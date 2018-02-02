<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class ClientsController extends Controller
{
	public function store(Request $request, User $user)
	{
		$this->authorize('create', User::class);
		$user->parent_id = $request->user()->id;
		$user->name      = $request->name;
		$user->wechat    = $request->wechat;
		$user->mobile    = $request->mobile;
		$user->avatar    = $request->avatar;
		$user->region    = $request->region;
		$user->address   = $request->address;
		$user->username  = $request->username;
		$user->password  = bcrypt($request->password);
		$user->save();

		return $this->response->item($user,new UserTransformer());
	}
}
