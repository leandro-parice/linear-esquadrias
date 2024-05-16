<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use File;
use Session;

use App\ProductImage;

class ProductImageController extends Controller
{
    private $rules = [
        'image' => 'required|image',
        'product_id' => 'required|integer',
        'order' => 'required|integer',
        'status' => 'required|boolean',
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

     public function index($productId)
    {
        $productImages = ProductImage::where('product_id', $productId)->orderBy('order', 'asc')->get();
        return view('admin.product-image.order', compact('productId', 'productImages'));        
    }

    public function create($productId)
    {
        $lastImage = ProductImage::where('product_id', $productId)->orderBy('order', 'desc')->first();
        if($lastImage){
            $order = $lastImage->order + 1;
        }else{
            $order = 1;
        }

        $productImage = new ProductImage;
        $productImage->status = 1;
        $productImage->product_id = $productId;
        $productImage->order = $order;

        return view('admin.product-image.form', compact('productId', 'productImage'));
    }

    public function store(Request $request, $productId)
    {
        $this->validate($request, $this->rules);

        $productImage = new ProductImage;
        $productImage->product_id = $request->product_id;
        $productImage->order = $request->order;
        $productImage->status = $request->status;

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $productImage->image = $this->saveImage($productImage, $image);
        }

        $productImage->save();

        Session::flash('alertText', 'Dados inseridos com sucesso!');
        return redirect( route('admin.product.image.index', $productId) );
    }

    public function show($id)
    {
        //
    }

    public function edit($productId, $id)
    {
        $productImage = ProductImage::find($id);
        return view('admin.product-image.form', compact('productId', 'productImage'));
    }

    public function update(Request $request, $productId, $id)
    {
        $rules = $this->rules;
        $rules['image'] = 'nullable|image';

        $this->validate($request, $rules);        

        $productImage = ProductImage::find($id);
        $productImage->product_id = $request->product_id;
        $productImage->order = $request->order;
        $productImage->status = $request->status;

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $productImage->image = $this->saveImage($productImage, $image);
        }

        $productImage->save();

        Session::flash('alertText', 'Dados editados com sucesso!');
        return redirect( route('admin.product.image.index', $productId) );
    }

    public function destroy($productId, $id)
    {
        $productImage = ProductImage::find($id);
        $productImage->delete();

        Session::flash('alertText', 'Dados removidos com sucesso!');            
        return redirect( route('admin.product.image.index', $productId) );
    }

    public function status(Request $request, $productId, $id)
    {
        $productImage = ProductImage::find($id);

        $status = ($productImage->status) ? false : true;
        $productImage->status = $status;
        $productImage->save();

        Session::flash('alertText', 'Status alterado com sucesso!');
        return redirect( route('admin.product.image.index', $productId) );
    }

    public function multiple(Request $request, $productId)
    {
        $lastImage = ProductImage::where('product_id', $productId)->orderBy('order', 'desc')->first();
        if($lastImage){
            $order = $lastImage->order + 1;
        }else{
            $order = 1;
        }

        foreach ($request->images as $image)
        {
            $productImage = new ProductImage;
            $productImage->product_id = $productId;
            $productImage->order = $order;
            $productImage->status = true;            

            $productImage->image = $this->saveImage($productImage, $image, $order);

            $productImage->save();

            $order += 1;
        }

        Session::flash('alertText', 'Dados inseridos com sucesso!');
        return redirect( route('admin.product.image.index', $productId) );
    }

    public function saveImage($model, $image, $count = 0)
    {
        if( !File::exists( public_path($model->path) ) ) {
            File::makeDirectory( public_path($model->path), 0777, true, true);
        }

        if(!empty($model->image)){
            File::delete(public_path($model->path.$model->image));
        }

        $imageExtension = ($image->getClientOriginalExtension() == 'jpeg') ? 'jpg' : $image->getClientOriginalExtension();
        
        $filename = time().$count.'.'.$imageExtension;
        $location = public_path($model->path.$filename);
        Image::make($image)
        ->resize(null, $model->height, function ($constraint) {
            $constraint->aspectRatio();
        })
        ->save($location);

        return $filename;
    }
}
