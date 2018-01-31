<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\HomeRequest;
use App\Models\Home;
use App\Transformers\HomeTransformer;
use App\Http\Controllers\Api\Controller;

class HomesController extends Controller
{
	public function index()
	{
		return $this->response->paginator(Home::paginate(4),new HomeTransformer());
    }

	public function store(HomeRequest $request)
	{
		Home::create($request->all());
		return $this->response->created();
    }

	public function destroy($home) // 隐式绑定无效
	{
		$home = Home::find($home);
		$home->delete();
		return $this->response->noContent();
    }
}
