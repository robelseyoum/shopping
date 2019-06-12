<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    //
    public function index(){

        /*
        $products = [ 
            0 =>["name" => "Iphone", "category" =>"smart phones", "prices" =>1000],
            1 =>["name" => "Galaxy", "category" =>"tablets", "prices" =>2000]
        ];
        */

        //$products = DB::table('products')->get();

        $products = Product::all();

        return view("allproducts", compact("products"));
    }
}
