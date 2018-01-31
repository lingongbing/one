<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\CarouselRequest;
use App\Models\Carousel;
use App\Transformers\CarouselTransformer;
use App\Http\Controllers\Api\Controller;

class CarouselsController extends Controller
{
	public function index()
	{
		return $this->response()->collection(Carousel::all(),new CarouselTransformer());
    }

	public function store(CarouselRequest $request)
	{
		Carousel::create($request->all());
		return $this->response->created();
    }

	public function destroy($carousel) //隐式绑定不生效
	{
		$carousel = Carousel::find($carousel);
		$carousel->delete();
		return $this->response->noContent();
	}
}
