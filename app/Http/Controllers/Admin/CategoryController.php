<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Session;
use Image;
use File;

use App\Category;

class CategoryController extends Controller
{
    private $rules = [
        'name' => 'required|string|max:255|min:3',
        'image' => 'required|image',
        'slug' => 'required|string|max:255|min:3|unique:categories',
        'description' => 'nullable|string|min:3',
        'status' => 'required|boolean'
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Category::orderBy('name', 'asc')->paginate(20);

        return view('admin.category.list', compact('categories'));
    }

    public function create()
    {
        $category = new Category;
        $category->status = 1;

        return view('admin.category.form', compact('category'));
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $category = new Category;
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->status = $request->status;

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $category->image = $this->saveImage($category, $image);
        }

        $category->save();

        Session::flash('alertText', 'Dados inseridos com sucesso!');
        return redirect( route('admin.category.index') );
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $category = Category::find($id);

        return view('admin.category.form', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        $rules = $this->rules;
        $rules['image'] = 'nullable|image';
        $rules['slug'] = [ 'required', 'string', 'max:255', 'min:3', Rule::unique('categories')->ignore($category->id) ];
        $this->validate($request, $rules);

        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->status = $request->status;

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $category->image = $this->saveImage($category, $image);
        }

        $category->save();

        Session::flash('alertText', 'Dados editados com sucesso!');
        return redirect( route('admin.category.index') );
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();

        Session::flash('alertText', 'Dados removidos com sucesso!');            
        return redirect( route('admin.category.index') );
    }

    public function status(Request $request, $id)
    {
        $category = Category::find($id);

        $status = ($category->status) ? false : true;
        $category->status = $status;
        $category->save();

        Session::flash('alertText', 'Status alterado com sucesso!');
        return redirect( route('admin.category.index') );
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
        Image::make($image)->fit($model->width, $model->height)->save($location);

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
