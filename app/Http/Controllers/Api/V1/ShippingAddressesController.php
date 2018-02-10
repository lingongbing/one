<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\ShippingAddressRequest;
use App\Models\ShippingAddress;
use App\Transformers\ShippingAddressTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class ShippingAddressesController extends Controller
{

    public function index(Request $request)
    {
        return $this->response->collection($request->user()->shippingAddresses,new ShippingAddressTransformer());
    }

    public function store(ShippingAddressRequest $request,ShippingAddress $shippingAddress)
    {
        $shippingAddress->create([
        	'user_id' => $request->user()->id,
        	'name' => $request->name,
        	'phone' => $request->phone,
	        'province' => $request->province,
        	'city' => $request->city,
        	'area' => $request->area,
        	'address' => $request->address
        ]);
        return $this->response->created();
    }

    public function destroy($shippingAddress)
    {
    	$shippingAddress = ShippingAddress::find($shippingAddress);
	    $this->authorize('update',$shippingAddress);
    	$shippingAddress->delete();
        return $this->response->noContent();
    }
}
