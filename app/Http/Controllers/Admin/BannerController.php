<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Carbon\Carbon;
use Image;
use File;

use App\Banner;

class BannerController extends Controller
{
    private $rules = [
        'name' => 'required|string|max:255|min:3',
        'image' => 'required|image',
        'position' => 'required|integer',
        'url' => 'nullable|url',
        'start' => 'nullable|date_format:"d/m/Y"',
        'end' => 'nullable|date_format:"d/m/Y"',
        'status' => 'required|boolean'
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $banners = Banner::orderBy('position', 'asc')->paginate(20);

        return view('admin.banner.list', compact('banners'));
    }

    public function create()
    {
        $banner = new Banner;
        $banner->status = 1;

        $lastBanner = Banner::orderBy('id', 'desc')->first();
        $position = ($lastBanner) ? ($lastBanner->position+1) : 1;

        $banner->position = $position;

        return view('admin.banner.form', compact('banner'));
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $start = ($request->start) ? Carbon::createFromFormat('d/m/Y', $request->start) : null;
        $end = ($request->end) ? Carbon::createFromFormat('d/m/Y', $request->end) : null;

        $banner = new Banner;
        $banner->name = $request->name;
        $banner->url = $request->url;
        $banner->position = $request->position;
        $banner->start = $start;
        $banner->end = $end;
        $banner->status = $request->status;

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $banner->image = $this->saveImage($banner, $image);
        }

        $banner->save();

        Session::flash('alertText', 'Dados inseridos com sucesso!');
        return redirect( route('admin.banner.index') );
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $banner = Banner::find($id);

        return view('admin.banner.form', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::find($id);

        $rules = $this->rules;
        $rules['image'] = 'nullable|image';
        $this->validate($request, $rules);

        $start = ($request->start) ? Carbon::createFromFormat('d/m/Y', $request->start) : null;
        $end = ($request->end) ? Carbon::createFromFormat('d/m/Y', $request->end) : null;

        $banner->name = $request->name;
        $banner->url = $request->url;
        $banner->position = $request->position;
        $banner->start = $start;
        $banner->end = $end;
        $banner->status = $request->status;

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $banner->image = $this->saveImage($banner, $image);
        }

        $banner->save();

        Session::flash('alertText', 'Dados editados com sucesso!');
        return redirect( route('admin.banner.index') );
    }

    public function destroy($id)
    {
        $banner = Banner::find($id);
        $banner->delete();

        Session::flash('alertText', 'Dados removidos com sucesso!');            
        return redirect( route('admin.banner.index') );
    }

    public function status(Request $request, $id)
    {
        $banner = Banner::find($id);

        $status = ($banner->status) ? false : true;
        $banner->status = $status;
        $banner->save();

        Session::flash('alertText', 'Status alterado com sucesso!');
        return redirect( route('admin.banner.index') );
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
