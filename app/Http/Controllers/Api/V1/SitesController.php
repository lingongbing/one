<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Site;
use App\Transformers\SiteTransformer;
use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;

class SitesController extends Controller
{
	public function index()
	{
		return $this->response->item(Site::first(),new SiteTransformer());
    }

	public function update(Request $request)
	{
		$site = Site::first();
		$site->update($request->all());

		return $this->response->item(Site::first(),new SiteTransformer());
    }
}
