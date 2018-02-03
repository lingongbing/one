<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\UserSkin;
use App\Transformers\UserSkinTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class UserSkinsController extends Controller
{
	public function show(Request $request)
	{
		$skin = UserSkin::where('user_id',$request->user()->id)->first();
		return $this->response->item($skin, new UserSkinTransformer());
	}

	public function store(Request $request, UserSkin $skin, $user)
	{
		$skin->user_id          = $user;
		$skin->create($request->all());

		return $this->response->created();
	}

	public function update(Request $request)
	{
		$skin = UserSkin::where('user_id',$request->user()->id)->first();
		$skin->update($request->all());

		return $this->response->item($skin, new UserSkinTransformer());
	}
}
