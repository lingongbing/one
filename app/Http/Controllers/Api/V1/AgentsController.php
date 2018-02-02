<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\AgentRequest;
use App\Http\Controllers\Api\Controller;
use App\Models\User;
use App\Transformers\AgentTransformer;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

class AgentsController extends Controller
{
	public function index(Request $request)
	{
		$conditions   = [];
		$conditions[] = ['is_agent', '=', true];
		if ($request->username) {
			$conditions[] = ['username', 'like', '%' . $request->username . '%'];
		}
		return $this->response->paginator(User::where($conditions)->paginate(10), new AgentTransformer());
	}

	public function store(AgentRequest $request, User $agent)
	{
		$agent->name         = $request->name;
		$agent->wechat       = $request->wechat;
		$agent->username     = $request->username;
		$agent->mobile       = $request->mobile;
		$agent->password     = bcrypt($request->password);
		$agent->introduction = $request->introduction;
		$agent->level        = $request->level;
		$agent->avatar       = $request->avatar;
		$agent->is_agent     = true;
		$agent->save();
		if ($request->is_home_management) {
			$agent->assignRole('home_management');
		}
		return $this->response->created();
	}

	public function show($agent)
	{
		return $this->response->item(User::find($agent), new UserTransformer());
	}

	public function update(AgentRequest $request, $agent)
	{
		$agent               = User::find($agent);
		$agent->name         = $request->name;
		$agent->wechat       = $request->wechat;
		$agent->introduction = $request->introduction;
		$agent->level        = $request->level;
		$agent->avatar       = $request->avatar;
		if ($request->password) {
			$agent->password = bcrypt($request->password);
		}
		$agent->save();
		if ($request->is_home_management && !$agent->hasRole('home_management')) {
			$agent->assignRole('home_management');
		} elseif (!$request->is_home_management && $agent->hasRole('home_management')) {
			$agent->removeRole('home_management');
		}
		return $this->response->item($agent, new UserTransformer());
	}
}
