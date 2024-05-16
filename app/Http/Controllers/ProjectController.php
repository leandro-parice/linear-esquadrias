<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Banner;
use App\Category;
use App\Product;

class ProjectController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');

        $banners = Banner::where('status', 1)
        ->where(function ($query) use ($today) {
            $query->where('start', '<=', $today)->orWhereNull('start');
        })
        ->where(function ($query) use ($today) {
            $query->where('end', '>=', $today)->orWhereNull('end');
        })
        ->orderBy('position', 'asc')
        ->get();

        $categories = Category::orderBy('name', 'asc')->get();

        return view('site.projects', compact('banners', 'categories'));
    }

    public function project($slug)
    {
        $category = Category::where('slug', $slug)->first();

        $products = Product::where('category_id', $category->id)->inRandomOrder()->get();

        $galleries = [];
        if($products->count() <= 1)
        {
            $product = Product::where('category_id', $category->id)->first();
            $images = $product->images;

            foreach ($images as $image)
            {
                $data = ['url' => $product->slug, 'image' => $image->path.$image->image];
                $galleries[] = $data;
            }
        }
        else
        {
            foreach ($products as $product)
            {
                $data = ['url' => $product->slug, 'image' => $product->path.$product->image];
                $galleries[] = $data;
            }
        }

    	return view('site.project', compact('category', 'galleries'));
    }

    public function gallery($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $images = $product->images;

    	return view('site.gallery', compact('product', 'images'));
    }
}
