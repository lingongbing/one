<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\IntegralGoodImageRequest;
use App\Models\IntegralGood;
use App\Models\IntegralGoodImage;
use App\Transformers\IntegralGoodImageTransformer;
use App\Http\Controllers\Api\Controller;

class IntegralGoodImagesController extends Controller
{
	public function index($integral_good)
	{
		$integral_good = IntegralGood::find($integral_good);
		return $this->response->collection($integral_good->image,new IntegralGoodImageTransformer());
    }

	public function update(IntegralGoodImageRequest $request,$integral_good,$image)
	{
		$image = IntegralGoodImage::find($image);
		$image->update([
			'image' => $request->image,
			'is_main' => $request->is_main
		]);
		return $this->response->item($image,new IntegralGoodImageTransformer());
    }

	public function store(IntegralGoodImageRequest $request,$integral_good,IntegralGoodImage $image)
	{
		$image->create([
			'image' => $request->image,
			'is_main' => $request->is_main,
			'integral_good_id' => $integral_good
		]);
		return $this->response->created();
    }
}
