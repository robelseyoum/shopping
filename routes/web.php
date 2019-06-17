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

Route::get('/', function () {
    return view('welcome');
});


Route::get('products', ["uses"=>"ProductsController@index", "as" => "allProducts"]);

//{{ route('AddToCartProduct', ['id'=>$product->id]) }}
Route::get('products/addToCart/{id}', ["uses"=>"ProductsController@addProductToCart", 'as'=>'AddToCartProduct']);


//show cart items
Route::get('cart', ["uses"=>"ProductsController@showCart", 'as'=>'cartproduts']);



//deleting items from cart 
Route::get('products/deleteItemFromCart/{id}', ["uses"=>"ProductsController@deleteItemFromCart", 'as'=>'DeleteItemFromCart']);


//user Authentication
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//Admin Panel
Route::get('admin/products', ["uses"=>"Admin\AdminProductsController@index", "as" => "adminDisplayProducts"]);


//display edit product form
Route::get('admin/editProductForm/{id}', ["uses"=>"Admin\AdminProductsController@editProductForm", "as" => "adminEditProductForm"]);


//display edit product image form
Route::get('admin/editProductImageForm/{id}', ["uses"=>"Admin\AdminProductsController@editProductImageForm", "as" => "adminEditProductImageForm"]);

//POST REQUEST
//update product image make sure use POST request// copy past code will lead to make this type of mistake
Route::post('admin/updateProductImage/{id}', ["uses"=>"Admin\AdminProductsController@updateProductImage", "as" => "adminUpdateProductImage"]);


//update edit product form with POST request
Route::post('admin/updateProduct/{id}', ["uses"=>"Admin\AdminProductsController@updateProduct", "as" => "adminUpdateProduct"]);






















