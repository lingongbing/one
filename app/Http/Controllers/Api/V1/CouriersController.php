<?php

namespace App\Http\Controllers\Api\V1;

use GuzzleHttp\Client;
use App\Http\Controllers\Api\Controller;
use GuzzleHttp\Exception\TransferException;

class CouriersController extends Controller
{
	public function show(Client $client,$courier)
	{
		try {
			$response = $client->get('https://wuliu.market.alicloudapi.com/kdi',[
				'headers' => [
					'Authorization' => 'APPCODE ' . env('ALIYUN_MARKET_KDI_APP_CODE'),
				],
				'query' => [
					'no' => $courier,
				]
			]);
		} catch (TransferException $exception) {
			if ($exception->getCode() === 403) {
				return $this->response->errorForbidden($exception->getCode());
			} else {
				return $this->response->errorInternal($exception->getMessage());
			}
		}

		return $this->response->array($response->getBody()->getContents());
    }
}
