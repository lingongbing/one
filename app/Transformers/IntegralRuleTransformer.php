<?php

namespace App\Transformers;

use App\Models\IntegralRule;
use League\Fractal\TransformerAbstract;

class IntegralRuleTransformer extends TransformerAbstract
{
	public function transform(IntegralRule $rule)
	{
		return [
			'id' => $rule->id,
			'created_user' => $rule->created_user,
			'complete_order' => $rule->complete_order
		];
	}
}