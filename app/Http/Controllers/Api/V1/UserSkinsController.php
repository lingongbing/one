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
		$skin = UserSkin::where('user_id', $request->user()->id)->first();
		return $this->response->item($skin, new UserSkinTransformer());
	}

	public function store(Request $request, UserSkin $skin)
	{
		$skin->create([
			'user_id' => $request->user()->id,
			'condition' => $request->condition,
			'check_time' => $request->check_time,
			'makeup_habits' => $request->makeup_habits,
			'skin_belong_id' => $request->skin_belong_id,
			'nursing_advice' => $request->nursing_advice,
			'characteristics' => $request->characteristics,
			'skin_category_id' => $request->skin_category_id,
			'commonly_products' => $request->commonly_products
		]);

		return $this->response->created();
	}

	public function update(Request $request)
	{
		$skin = UserSkin::where('user_id', $request->user()->id)->first();
		$skin->update($request->all());

		return $this->response->item($skin, new UserSkinTransformer());
	}
}
