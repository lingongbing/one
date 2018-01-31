<?php

namespace App\Transformers;

use App\Models\Home;
use League\Fractal\TransformerAbstract;

class HomeTransformer extends TransformerAbstract
{
	public function transform(Home $home)
	{
		return [
			'id' => $home->id,
			'link' => $home->link,
			'image' => $home->image
		];
	}
}