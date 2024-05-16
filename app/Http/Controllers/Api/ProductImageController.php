<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\ProductImage;

class ProductImageController extends Controller
{
    public function order(Request $request)
    {
		$datas = $request->all();

    	foreach ($datas['data'] as $value)
    	{
    		$productImage = ProductImage::find($value['id']);
    		$productImage->order = $value['order'];
    		$productImage->save();
    	}

    	return response()->json(['success' => true]);
    }
}
