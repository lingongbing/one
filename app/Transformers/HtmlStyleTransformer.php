<?php

namespace App\Transformers;

use App\Models\HtmlStyle;
use League\Fractal\TransformerAbstract;

class HtmlStyleTransformer extends TransformerAbstract
{
	public function transform(HtmlStyle $style)
	{
		return [
			'background-color' => $style->background_color
		];
	}
}