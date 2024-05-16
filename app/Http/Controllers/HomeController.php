<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Banner;
use App\Product;

class HomeController extends Controller
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

    	$products = Product::inRandomOrder()->limit(5)->get();

        return view('site.home', compact('banners', 'products'));
    }

    public function home()
    {
    	return redirect()->route('home');
    }
}
