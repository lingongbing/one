<?php

namespace App\Transformers;

use App\Models\Site;
use League\Fractal\TransformerAbstract;

class SiteTransformer extends TransformerAbstract
{
	public function transform(Site $site)
	{
		return [
			'logo_url' => $site->logo_url,
			'copyright' => $site->copyright,
		];
	}
}