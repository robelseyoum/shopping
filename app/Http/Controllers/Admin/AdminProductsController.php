<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Product;

class AdminProductsController extends Controller
{
    //display all products
    public function index()
    {


        $products = Product::all();

        return view("admin.displayProducts", ["products"=>$products]);
    }

   //display edit product data
   public function editProductForm($id)
   {

        //fetch a single product data from the db with id
        $product = Product::find($id);

        return view("admin.editProductForm", ["product"=>$product]);

   }

   //display edit product image
   public function editProductImageForm($id)
   {
        //fetch a single product data from the db with id
         $product = Product::find($id);

        return view("admin.editProductImageForm", ["product"=>$product]);
   }

}
