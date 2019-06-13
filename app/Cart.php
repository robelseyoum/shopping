<?php  

namespace App;

class Cart
{
    public $items; // ['id' => ['quantity' => , 'price' =>, 'data']] data = will hold the attributes of the product from the db
    public $totalQuantity;
    public $totalPrice;

    public function __construct($prevCart)
    {
        if($prevCart != null)
        {
            $this->items = $prevCart->items;
            $this->totalQuantity = $prevCart->totalQuantity;
            $this->totalPrice = $prevCart->totalPrice;
        }
        else 
        {
            $this->items = [];
            $this->totalQuantity = 0;
            $this->totalPrice = 0;
        }
    }

    public function addItem($id, $product)
    {
        //convert the string price to int by parsing
        $price = (int) str_replace("$", "", $product->price);

        //check if the item is already is exist
        if(array_key_exists($id, $this->items))
        {
            // it get Items Id where it holds the 'quantity', 'price' and 'data'
            //['id' => ['quantity' => , 'price' =>, 'data']] 
            //example 
            //$productToAdd = ['quantity' =>1, 'price' => $price, 'data' =>$product];
            //data = will hold the attributes of the product from the db
            $productToAdd = $this->items[$id];
            $productToAdd['quantity']++;

        }//first time the product added into the cart
        else
        {
            $productToAdd = ['quantity' =>1, 'price' => $price, 'data' =>$product];
        }

        //here we update the arrays with thier specific values
        $this->items[$id] = $productToAdd;
        $this->totalQuantity++;
        $this->totalPrice = $this->totalPrice + $price;
    }

}












