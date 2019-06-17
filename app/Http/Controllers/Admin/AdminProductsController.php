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
        
        //Replace the characters "world" in the string "Hello world!" with "Peter":
        //str_replace("world","Peter","Hello world!");
        
        $parseDollarSign = (Int) str_replace("$", " ", $request->input('price'));

        $updateArray = array('name'=>$name, 'description'=>$description, 'type'=>$type, 'price'=>$parseDollarSign);
        DB::table('products')->where('id', $id)->update($updateArray);

        return redirect()->route('adminDisplayProducts');

   }

   //create new product 
    public function createProductForm()
    {
        return view("admin.createProductForm");
    }

    // create new data to store the to the file
    public function sendCreateProductForm(Request $request)
    {
        $name = $request->input('name');
        $description = $request->input('description');
        $type = $request->input('type');
        $price = $request->input('price');

        Validator::make($request->all(), ['image'=>"required|file|image|mimes:jpg,png,jpeg|max:5000"])->validate();

        //upload the image
        //parsing the image file extenstion
        $imageExt = $request->file('image')->getClientOriginalExtension(); //jpg, png, gif...
        $stringImageReFormat = str_replace(" ", "", $request->input('name'));

        $imageName = $stringImageReFormat.".".$imageExt; //blackdress.jpg
        $imageEncoded = File::get($request->image);

        Storage::disk('local')->put("public/product_images/".$imageName, $imageEncoded);

        $newUpdateArray = array('name'=>$name, 'description'=>$description, 'image'=>$imageName, 'type'=>$type, 'price'=>$price);
        
        $created = DB::table('products')->insert($newUpdateArray);

        if($created)
        {
            return redirect()->route('adminDisplayProducts');
        }
        else
        {
            return "Product was not Created";
        }

    }

    //delete a product from the db and the web
    public function deleteProduct($id)
    {
        $product = Product::find($id);
        $exists = Storage::disk('local')->exists("public/product_images/".$product['image']); //return either true or false

        //delete old images
        if($exists)
        {
            Storage::delete("public/product_images/".$product->image);
        } 

        Product::destroy($id);

        return redirect()->route('adminDisplayProducts');

    }















}
