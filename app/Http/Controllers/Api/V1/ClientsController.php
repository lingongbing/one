<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\ClientRequest;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class ClientsController extends Controller
{
	public function index(Request $request)
	{
		$this->authorize('is_agent', User::class);
		$conditions = [];

		if ($request->username) {
			$conditions[] = ['username', '=', $request->username];
		}

		if ($request->name) {
			$conditions[] = ['name', '=', $request->name];
		}

		if ($request->mobile) {
			$conditions[] = ['mobile', '=', $request->mobile];
		}

		if ($request->wechat) {
			$conditions[] = ['wechat', '=', $request->wechat];
		}

		if ($request->parent_id && $request->user()->hasRole('admin')) {
			$conditions[] = ['parent_id', '=', $request->parent_id];
		}

		return $this->response->paginator(User::where($conditions)->paginate(10), new UserTransformer());
	}

	public function store(ClientRequest $request, User $user)
	{
		$this->authorize('create', User::class);
		$user->parent_id = $request->user()->id;
		$user->name      = $request->name;
		$user->wechat    = $request->wechat;
		$user->mobile    = $request->mobile;
		$user->avatar    = $request->avatar;
		$user->region    = $request->region;
		$user->address   = $request->address;
		$user->username  = $request->username;
		$user->password  = bcrypt($request->password);
		$user->save();

		return $this->response->item($user, new UserTransformer());
	}

	public function show($client)
	{
		return $this->response->item(User::find($client), new UserTransformer());
	}

	public function update(ClientRequest $request, $client)
	{
		$client          = User::find($client);
		$client->name    = $request->name;
		$client->wechat  = $request->wechat;
		$client->avatar  = $request->avatar;
		$client->region  = $request->region;
		$client->mobile  = $request->mobile;
		$client->address = $request->address;
		if ($request->password) {
			$client->password = bcrypt($request->password);
		}
		$client->save();

		return $this->response->item($client,new UserTransformer());
	}
}
