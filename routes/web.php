<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home' , function(){
    return view('homepage');
});

Route::get('/contact' , function(){
    return view('contactus');
});

Route::get('/about' , function(){
    return view('aboutus');
});

use App\Http\Controllers\ProductsController;

Route::resource('products' , ProductsController::class);

//Route::get('/validate/{id}' , [ProductsController::class, 'ask']);

use App\Http\Controllers\CategoriesController;

Route::resource('categories' , CategoriesController::class);

//Route::get('/validate2/{id}' , [CategoriesController::class, 'ask']);

//  products ......................................................................... products.index › ProductsController@index
//  POST            products ......................................................................... products.store › ProductsController@store
//  GET|HEAD        products/create ................................................................ products.create › ProductsController@create
//  GET|HEAD        products/{product} ................................................................. products.show › ProductsController@show
//  PUT|PATCH       products/{product} ............................................................. products.update › ProductsController@update
//  DELETE          products/{product} ........................................................... products.destroy › ProductsController@destroy
//  GET|HEAD        products/{product}/edit ............................................................ products.edit › ProductsController@edit

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
