<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Intervention\Image\Exception\ImageException;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Api\Controller;

class UploadsController extends Controller
{
	public function store(Request $request)
	{
		$this->validate($request,[
			$request->key => 'image'
		]);

		$path =  $request->file($request->key)->store('public');

		if ($request->width || $request->height)
		{
			try {
				$disk_path = public_path('storage') . '/' .$path;
				$img = Image::make($disk_path);
				$img->resize($request->width,$request->height);
				$img->save($disk_path);
			} catch (ImageException $exception) {
				return $this->response->errorInternal($exception->getMessage());
			}
		}

		return $this->response->array([
			'path' => url('/storage/' . $path)
		]);
	}
}
