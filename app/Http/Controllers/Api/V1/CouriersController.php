<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\AliyunMarket;
use GuzzleHttp\Client;
use App\Http\Controllers\Api\Controller;
use GuzzleHttp\Exception\TransferException;

class CouriersController extends Controller
{
	public function show(Client $client,$courier)
	{
		try {
			$market = AliyunMarket::find('kdi');
			$response = $client->get('https://wuliu.market.alicloudapi.com/kdi',[
				'headers' => [
					'Authorization' => 'APPCODE ' . $market->app_code,
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
