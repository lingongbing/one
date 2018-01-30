<?php

namespace App\Transformers;

use App\Models\Carousel;
use League\Fractal\TransformerAbstract;

class CarouselTransformer extends TransformerAbstract
{
	public function transform(Carousel $carousel)
	{
		return [
			'id' => $carousel->id,
			'link' => $carousel->link,
			'image' => url($carousel->image)
		];
	}
}