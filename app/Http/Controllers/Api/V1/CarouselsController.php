<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Carousel;
use App\Transformers\CarouselTransformer;
use App\Http\Controllers\Api\Controller;

class CarouselsController extends Controller
{
	public function index()
	{
		return $this->response()->collection(Carousel::all(),new CarouselTransformer());
    }
}
