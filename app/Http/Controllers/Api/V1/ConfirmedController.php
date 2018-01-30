<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\V1\ConfirmedRequest;

class ConfirmedController extends Controller
{
	public function index(ConfirmedRequest $request)
	{
		return $this->response->noContent();
    }
}
