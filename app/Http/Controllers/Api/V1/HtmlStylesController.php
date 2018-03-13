<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\HtmlStyle;
use App\Transformers\HtmlStyleTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class HtmlStylesController extends Controller
{
	public function index()
	{
		return $this->response->item(HtmlStyle::first(),new HtmlStyleTransformer());
    }

	public function update(Request $request,HtmlStyle $style)
	{
		$style = $style->first();
		$style->background_color = $request->background_color;
		$style->save();
		return $this->response->item($style,new HtmlStyleTransformer());
    }
}
