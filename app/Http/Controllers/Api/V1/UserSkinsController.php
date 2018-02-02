<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\UserSkin;
use App\Transformers\UserSkinTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class UserSkinsController extends Controller
{
	public function show(Request $request,$user)
	{
		if ($user) {
			$skin = UserSkin::where('user_id',$user)->first();
		} else {
			$skin = $request->user()->skin;
		}

		return $this->response->item($skin,new UserSkinTransformer());
	}

	public function store(Request $request, UserSkin $skin, $user)
	{
		$skin->user_id          = $user;
		$skin->condition        = $request->condition;
		$skin->check_time       = $request->check_time;
		$skin->makeup_habits    = $request->makeup_habits;
		$skin->nursing_advice   = $request->nursing_advice;
		$skin->characteristics  = $request->characteristics;
		$skin->skin_category_id = $request->skin_category_id;
		$skin->save();

		return $this->response->created();
	}
}
