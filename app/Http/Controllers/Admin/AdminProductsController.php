<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


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

   //update the exsiting image
   public function updateProductImage(Request $request, $id)
   {

    Validator::make($request->all(), ['image'=>"required|file|image|mimes:jpg,png,jpeg|max:5000"])->validate();

    if($request->hasFile('image'))
    {
  
        $product = Product::find($id);
        $exists = Storage::disk('local')->exists("public/product_images/".$product['image']); //return either true or false

        //delete old images
        if($exists)
        {
            Storage::delete("public/product_images/".$product->image);
        }

        //upload the image
        //parsing the image file extenstion
         $ext = $request->file('image')->getClientOriginalExtension(); //jpg, png, gif...

         //here upload the new image with the same name that is fetched from db
         $request->image->storeAs("public/product_images/", $product->image);

         //$path = $request->photo->storeAs('images', 'filename.jpg');
        
        //in case if we change the image name or use different image name
         $arrayToUpdate = array('image'=>$product->image);
         DB::table('products')->where('id', $id)->update($arrayToUpdate);

         return redirect()->route('adminDisplayProducts');
    }
     //if the image is not exist and if the user dont' make any image update    
    else
    {
        $error = "NO Image was Selected";

        return $error;
    }
    

   }

   public function updateProduct(Request $request, $id)
   {
        $name = $request->input('name');
        $description = $request->input('description');
        $type = $request->input('type');
        $price = $request->input('price');

        $updateArray = array('name'=>$name, 'description'=>$description, 'type'=>$type, 'price'=>$price);
        DB::table('products')->where('id', $id)->update($updateArray);

        return redirect()->route('adminDisplayProducts');

   }






















}
