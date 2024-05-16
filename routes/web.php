<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@home');
Route::get('/linear', 'CompanyController@index')->name('company');
Route::get('/projetos', 'ProjectController@index')->name('projects');
Route::get('/projetos/{type}', 'ProjectController@project')->name('project');
Route::get('/galeria/{type}', 'ProjectController@gallery')->name('gallery');
Route::get('/orcamentos', 'BudgetController@index')->name('budget');
Route::post('/orcamentos', 'BudgetController@send')->name('budget.send');
Route::get('/contato', 'ContactController@index')->name('contact');
Route::post('/contato', 'ContactController@send')->name('contact.send');

//login
Auth::routes();
Route::get('/register', function () {
    return redirect('/login');
});

//admin
Route::prefix('admin')->group(function(){
	Route::get('/', function () {
	    return redirect()->route('admin.dashboard');
	});
	Route::get('/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');

	Route::get('/profile', 'Admin\ProfileController@index')->name('admin.profile');
	Route::post('/profile', 'Admin\ProfileController@update')->name('admin.profile.update');

	Route::resource('user', 'Admin\UserController', ['as' => 'admin']);

	Route::resource('banner', 'Admin\BannerController', ['as' => 'admin']);
	Route::put('banner/{id}/status', 'Admin\BannerController@status')->name('admin.banner.status');

	Route::resource('category', 'Admin\CategoryController', ['as' => 'admin']);
	Route::put('category/{id}/status', 'Admin\CategoryController@status')->name('admin.category.status');

	Route::resource('product', 'Admin\ProductController', ['as' => 'admin']);
	Route::put('product/{id}/status', 'Admin\ProductController@status')->name('admin.product.status');

	Route::get('product/{product}/image', 'Admin\ProductImageController@index')->name('admin.product.image.index');
	Route::get('product/{product}/image/create', 'Admin\ProductImageController@create')->name('admin.product.image.create');
	Route::post('product/{product}/image', 'Admin\ProductImageController@store')->name('admin.product.image.store');
	Route::get('product/{product}/image/{image}/edit', 'Admin\ProductImageController@edit')->name('admin.product.image.edit');
	Route::match(['put', 'patch'], 'product/{product}/image/{image}', 'Admin\ProductImageController@update')->name('admin.product.image.update');
	Route::delete('product/{product}/image/{image}', 'Admin\ProductImageController@destroy')->name('admin.product.image.destroy');
	Route::put('product/{product}/image/{image}/status', 'Admin\ProductImageController@status')->name('admin.product.image.status');
	Route::post('product/{product}/image/multiple', 'Admin\ProductImageController@multiple')->name('admin.product.image.multiple');
});
