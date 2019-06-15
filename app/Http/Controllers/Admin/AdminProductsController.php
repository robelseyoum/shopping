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

}
