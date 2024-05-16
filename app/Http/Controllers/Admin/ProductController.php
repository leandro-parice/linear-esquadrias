<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Session;
use Image;
use File;

use App\Category;
use App\Product;

class ProductController extends Controller
{
    private $rules = [
        'category_id' => 'required|integer',
        'name' => 'required|string|max:255|min:3',
        'image' => 'required|image',
        'slug' => 'required|string|max:255|min:3|unique:products',
        'description' => 'nullable|string|min:3',
        'status' => 'required|boolean'
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = Product::orderBy('name', 'asc')->paginate(20);

        return view('admin.product.list', compact('products'));
    }

    public function create()
    {
        $product = new Product;
        $product->status = 1;

        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.product.form', compact('product', 'categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $product = new Product;
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->status = $request->status;

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $product->image = $this->saveImage($product, $image);
        }

        $product->save();

        Session::flash('alertText', 'Dados inseridos com sucesso!');
        return redirect( route('admin.product.index') );
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $product = Product::find($id);

        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.product.form', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        $rules = $this->rules;
        $rules['image'] = 'nullable|image';
        $rules['slug'] = [ 'required', 'string', 'max:255', 'min:3', Rule::unique('products')->ignore($product->id) ];
        $this->validate($request, $rules);

        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->status = $request->status;

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $product->image = $this->saveImage($product, $image);
        }

        $product->save();

        Session::flash('alertText', 'Dados editados com sucesso!');
        return redirect( route('admin.product.index') );
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        Session::flash('alertText', 'Dados removidos com sucesso!');            
        return redirect( route('admin.product.index') );
    }

    public function status(Request $request, $id)
    {
        $product = Product::find($id);

        $status = ($product->status) ? false : true;
        $product->status = $status;
        $product->save();

        Session::flash('alertText', 'Status alterado com sucesso!');
        return redirect( route('admin.product.index') );
    }

    public function saveImage($model, $image)
    {
        if( !File::exists( public_path($model->path) ) ) {
            File::makeDirectory( public_path($model->path), 0777, true, true);
        }

        if(!empty($model->image)){
            File::delete(public_path($model->path.$model->image));
        }

        $imageExtension = ($image->getClientOriginalExtension() == 'jpeg') ? 'jpg' : $image->getClientOriginalExtension();
        
        $filename = time().'-'.$this->slugify($model->name).'.'.$imageExtension;
        $location = public_path($model->path.$filename);
        Image::make($image)
        ->resize(null, $model->height, function ($constraint) {
            $constraint->aspectRatio();
        })
        ->save($location);

        return $filename;
    }

    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, '-');
        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        // lowercase
        $text = strtolower($text);

        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }
}
