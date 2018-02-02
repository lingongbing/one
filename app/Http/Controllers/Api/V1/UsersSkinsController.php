<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\UserSkin;
use App\Transformers\UserSkinTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class UsersSkinsController extends Controller
{
	public function index($user)
	{
		return $this->response->item(UserSkin::where('user_id',$user)->get(),new UserSkinTransformer());
	}

	public function show(Request $request,$user = false)
	{
		if (!$user) {
			$user = $request->user()->id;
		}

		$skin = UserSkin::where('user_id',$user)->get();
		return $this->response->item($skin,new UserSkinTransformer());
	}

	public function store(Request $request, UserSkin $skin, $user)
	{
		$skin->user_id          = $user;
		$skin->condition        = $request->condition;
		$skin->check_time       = $request->check_time;
		$skin->makeup_habits    = $request->makeup_habits;
		$skin->nursing_advice   = $request->nursing_advice;
		$skin->skin_belong_id   = $request->skin_belong_id;
		$skin->characteristics  = $request->characteristics;
		$skin->skin_category_id = $request->skin_category_id;
		$skin->commonly_products = $request->commonly_products;
		$skin->save();

		return $this->response->created();
	}
}
