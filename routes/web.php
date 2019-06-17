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


//create a new product form url route
Route::get('admin/createProductForm', ["uses"=>"Admin\AdminProductsController@createProductForm", "as" => "adminCreateProductForm"]);


// using POST request send the data to database
Route::post('admin/sendCreateProductForm', ["uses"=>"Admin\AdminProductsController@sendCreateProductForm", "as" => "adminSendCreateProductForm"]);


//delete a product form the db and the web
Route::get('admin/deleteProduct/{id}', ["uses"=>"Admin\AdminProductsController@deleteProduct", "as" => "adminDeleteProduct"]);



//storage usage to get images, it is depends on a different ways
Route::get('/testStorage', function(){
    /*
        return "<img src=".Storage::url('product_images/'.$product->image).">";

        return Storage::disk('local')->url('product_images/'.$product->image);

        Storage::disk('local')->exists("public/product_images/".$product['image']);
        Storage::delete("public/product_images/".$product->image);
    */
});













