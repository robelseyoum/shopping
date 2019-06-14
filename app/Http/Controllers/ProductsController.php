<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Cart;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    //
    public function index()
    {

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




    //$request allows to access the session when we store morethan one elements
    public function addProductToCart(Request $request, $id)
    {    

        //remove items from the cart
        // $request->session()->forget("cart");
        // $request->session()->flush();

         //call the session with id    
         $prevCart = $request->session()->get('cart');
         $cart = new Cart($prevCart);

         //fetch the product data from the db with id
         $product = Product::find($id);
         $cart->addItem($id, $product);

         //if session is already exist it will over ride it with $cart
         $request->session()->put('cart', $cart);

         //dump($cart);
         //redirect after each time the user added the item into the cart
         return redirect()->route("allProducts");
    }



    public function showCart()
    {
        $cart = Session::get('cart');

        //cart is not empty
        if($cart)
        {
            //dump($cart);
            return view('cartproduts', ['cartItems' => $cart]);
        }// cart is empty
        else
        {
            //echo "The Cart is empty";
            return redirect()->route("allProducts");
        }
    }

    public function deleteItemFromCart(Request $request, $id)
    {
        $cart = $request->session()->get("cart");

        if(array_key_exists($id, $cart->items))
        {
            unset($cart->items[$id]);
        }

        $prevCart = $request->session()->get('cart');
        $updatedCart = new Cart($prevCart);
        $updatedCart->updatePriceAndQuantity();

        //update the session
        $request->session()->put('cart', $updatedCart);

        //redirect to cart page
        return redirect()->route("cartproduts");
    }











}
