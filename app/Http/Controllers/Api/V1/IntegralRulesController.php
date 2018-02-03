<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\IntegralRule;
use App\Transformers\IntegralRuleTransformer;
use App\Http\Controllers\Api\Controller;
use Dingo\Api\Http\Request;

class IntegralRulesController extends Controller
{
	public function index()
	{
		return $this->response->item(IntegralRule::first(),new IntegralRuleTransformer());
    }

	public function update(Request $request)
	{
		$rule = IntegralRule::first();
		$rule->update($request->all());

		return $this->response->item($rule,new IntegralRuleTransformer());
    }
}
