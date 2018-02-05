<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;

class SystemController extends Controller
{
	public function index()
	{
		$data['server_addr']     = $_SERVER['SERVER_ADDR'];
		$data['server_name']     = $_SERVER['SERVER_NAME'];
		$data['server_port']     = $_SERVER['SERVER_PORT'];
		$data['system_type']     = php_uname('s');
		$data['system_version']  = php_uname('r');
		$data['php_version']     = PHP_VERSION;
		$data['zend_version']    = Zend_Version();
		$data['php_sapi_name']   = php_sapi_name();
		$data['server_date']     = date('Y-m-d H:i:s');
		$data['server_software'] = $_SERVER['SERVER_SOFTWARE'];
		return response()->json($data);
    }
}
