<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\GoodsRequest;
use App\Http\Controllers\Api\Controller;
use App\Models\Good;
use App\Transformers\GoodTransformer;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
	public function index(Request $request)
	{
		$conditions = [];
		if ($request->name) {
			$conditions[] = ['name', 'like', '%' . $request->name . '%'];
		}
		$goods = Good::where($conditions)->orderBy('id','desc')->paginate(2);
		return $this->response->paginator($goods, new GoodTransformer());
	}

	public function store(GoodsRequest $request, Good $good)
	{
		$good->name  = $request->name;
		$good->image = $request->image;
		$good->save();

		return $this->response->created();
	}

	// 隐式绑定不生效
	public function destroy($good)
	{
		Good::destroy($good);
		return $this->response->noContent();
	}
}
