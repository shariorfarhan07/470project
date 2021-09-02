<?php


namespace App;


class Cart
{  public $items;// ['id'=>[quantity=.,'price'=>,'data'=>]]
   public $totalQuantity;
   public $totalPrice;


    public function  __construct($preCart)
    {
        if($preCart!=null){
          $this->items=$preCart->items;
          $this->totalQuantity=$preCart->totalQuantity;
          $this->totalPrice=$preCart->totalPrice;
        }else{
            $this->items=[];
            $this->totalQuantity=0;
            $this->totalPrice=0;

        }

    }
    public function addItem($id,$product){
        // the item already exists
        if(array_key_exists($id,$this->items)){
           $productToAdd=$this->items[$id];
           $productToAdd['quantity']++;


            //first time add this product to cart
        }
        else{
            $productToAdd=['quantity'=>1,'price'=>$product->price,'data'=>$product];
        }
        $this->items[$id]=$productToAdd;
        $this->totalQuantity++;
        $this->totalPrice=$this->totalPrice+$product->price;//$price
    }
    public function removeFromCart($id,$number){

        if(array_key_exists($id,$this->items)){
            $this->items[$id]['quantity']=$number;
            if( $this->items[$id]['quantity']<=0) {
               unset($this->items[$id]);
            }
        }
        $this->totalQuantity=0;
        $sum=0;
        $totalp=0;
            foreach ( $this->items as $value) {
                $sum+=$value['quantity'];
                $totalp+=$value['quantity']*$value['price'];
            }
            $this->totalQuantity=$sum;
            $this->totalPrice=$totalp;

    }

}
