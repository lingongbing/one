<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\LevelRequest;
use App\Models\Level;
use App\Transformers\LevelTransformer;
use App\Http\Controllers\Api\Controller;

class LevelsController extends Controller
{
	public function index()
	{
		return $this->response->collection(Level::all(),new LevelTransformer());
	}

	public function store(LevelRequest $request)
	{
		Level::create($request->all());
		return $this->response->created();
	}

	public function destroy($level) //隐式绑定不生效
	{
		$level = Level::find($level);
		$level->delete();
		return $this->response->noContent();
	}
}
