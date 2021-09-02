<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Models\book;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{



    public function mailorder(Request $request){
        $data=$request->all();
        $user='shariorfarhan77@gmail.com';
        Mail::send('mail',$data,function($messages)use($data,$user){
            $messages->to($user);
            $messages->subject('Book Request:'.$data['first_name'].' '.$data['last_name'].' '.$data['phone']);
            $messages->attach($data['pdf']->getRealPath(),
                array('as'=>'book'.$data['pdf']->getClientOriginalExtension(),
                    'mime'=>$data['pdf']->getMimeType()));
        });
        return redirect()->route('home')->with('success','Request hasbeen placed!');
    }




    public function index()
    {
        $products1 = book::orderBy('id', 'desc')->where('category', 'best seller')->take(12)->get();
        $products2 =book::orderBy('id', 'desc')->where('category', 'programming')->take(12)->get();
        $products3 =book::orderBy('id', 'desc')->where('category', 'engineering')->take(12)->get();
        $products4 = book::orderBy('id', 'desc')->where('category', 'academic')->take(12)->get();
        $products5 = book::orderBy('id', 'desc')->where('category', 'olympiad')->take(12)->get();
        return view("main.index")->with('products1', $products1)->with('products2', $products2)->with('products3', $products3)->with('products4', $products4)->with('products5', $products5);
    }


    public function category($category){
        $products = book::orderBy('id', 'desc')->where('category', $category)->paginate(24);
        if($products['total']){
            $products = book::orderBy('id', 'desc')->where('name', 'Like', "%".$category."%")->paginate(24);
        }

        return view("main.shopgrid", compact("products"))->with('category',$category);
    }

    public function search(Request $request){
        $searchText=$request->input('search');
        $products = book::where('name', 'Like', "%" . $searchText . "%")->
        orWhere('author', 'LIKE', '%' . $searchText . '%')->
        orWhere('publisher', 'LIKE', '%' . $searchText . '%')->
        orWhere('category', 'LIKE', '%' . $searchText . '%')->paginate(24);
        $category=null;
        return view("main.shopgrid", compact("products",$products))->with('category',$category);
    }


    public function slugview($slug){
        $book = book::where('slug',$slug)->first();
        return view("main.book", compact("book"));

    }



    public function orderview()
    {
        $cart = Session::get('cart');
        if ($cart) {
            return view('main.order');
        }

        return view('main.index') ->with('warning','You Dont have any product in cart! please add product to your cart!');
    }


    public function curtview()
    {
        $cart = Session::get('cart');
        if ($cart) {

            return view('main.order',compact(['cart', $cart ]));
        }

        return view('main.index') ->with('warning','You Dont have any product in cart! please add product to your cart to continue!');
    }


    public function AddToCartProduct(Request $request, $id)
    {
        $prevCart = $request->session()->get('cart');
        $cart = new Cart($prevCart);
        $product = book::find($id);
        $cart->addItem($id, $product);
        $request->session()->put('cart', $cart);
        //return redirect()->route('home') ->with('success','You Dont have any product in cart! please add product to your cart to continue!');
        return redirect()->back()->with('success','You Dont have any product in cart! please add product to your cart to continue!');

    }

    public function adjustcart(Request $request, $id, $number)
    {
        $prevCart = $request->session()->get('cart');
        $cart = new Cart($prevCart);
        $cart->removeFromCart($id, $number);
        $request->session()->put('cart', $cart);
        return redirect()->back()->with('success','Successfully adjusted cart!');


    }

    public function cartview(Request $request){
        $cartItems = $request->session()->get('cart');


        if($cartItems && $cartItems->totalQuantity>0){
            return view('main.cart',['cartItems'=>$cartItems]);
        }else{
             return redirect()->route("home")->with('warning','you dont have any product in cart. please add product!');
        }

    }
    public function logout(){
        Auth::logout();
        return redirect()->back();
    }





    public function sendorder(Request $request){
        $user=$request->all();
        unset($user['_token']);
        $cart = Session::get('cart');
        //cart is not empty
        if ($cart) {
            //dump($cart);
            $date = date('Y-m-d H:i:s');
            $newOrderArray = $user;
            $created_order = DB::table('orders')->insert($newOrderArray);
            $order_id = DB::getPdo()->lastInsertId();
            foreach ($cart->items as $cart_item) {
                $item_id = $cart_item['data']['id'];
                $item_name = $cart_item['data']['name'];
                $item_price = $cart_item['data']['price'];
                $qty = $cart_item['quantity'];
                $newOrderItem = array('order_id' => $order_id, 'item_id' => $item_id, 'item_name' => $item_name, 'item_price' => $item_price, 'qty' => $qty);
                $created_order_items = DB::table('orderlists')->insert($newOrderItem);
            }
            $cartItems = $request->session()->get('cart');
            $data=$user;
            $data['cartItems']=$cartItems;
            $user='shariorfarhan77@gmail.com';
            Mail::send('mail2',$data,function($messages)use($data,$user){
                $messages->to($user);
                $messages->subject('Book order:'.$data['first_name'].' '.$data['last_name'].' '.$data['phone']);

            });


            Session::forget('cart');
            Session::flush();
            return redirect()->route("home")->with('success','Thanks For Choosing us');

        } else {
            return redirect()->route("home")->with('success','Nothing in curt');
        }


    }







//
//    public function billingconfirm(Request $request)
//    {
//        $first_name = $request->input('firstname');
//        $last_name = $request->input('lastname');
//
//        $name = $first_name . " " . $last_name;
//        $phone = $request->input('phone');
//        $email = $request->input('email');
//        $address = $request->input('address') . $request->input('flat');
//        $division = $request->input('division');
//        $city = $request->input('city');
//        $paymentmethod = $request->input('paymentmethod');
//        $zip = $request->input('zip');
//        $shipping = 0;
//        if ($division == "Dhaka") {
//            $shipping = 60;
//        } else {
//            $shipping = 100;
//        }
//        if ($paymentmethod == 'bkash') {
//            $paymentnumber = $request->input('paymentnumber');
//            $txid = $request->input('txid');
//        } else {
//            $paymentnumber = 'cash on delevery';
//            $txid = 'cash on delevery';
//        }
//
//
//        $cart = Session::get('cart');
//        //cart is not empty
//        if ($cart) {
//            //dump($cart);
//            $date = date('Y-m-d H:i:s');
//            $newOrderArray = array('shipping' => $shipping, 'zip' => $zip, 'date' => $date, 'txid' => $txid, 'bkashnumber' => $paymentnumber, 'status' => 'our representative will call you', 'payment' => $cart->totalPrice, 'name' => $name, 'email' => $email, 'phone' => $phone, 'address' => $address, 'division' => $division, 'city' => $city);
//            $created_order = DB::table('orders')->insert($newOrderArray);
//            $order_id = DB::getPdo()->lastInsertId();
//            foreach ($cart->items as $cart_item) {
//                $item_id = $cart_item['data']['id'];
//                $item_name = $cart_item['data']['Name'];
//                $item_price = $cart_item['data']['price'];
//                $qty = $cart_item['quantity'];
//                $newOrderItem = array('order_id' => $order_id, 'item_id' => $item_id, 'item_name' => $item_name, 'item_price' => $item_price, 'qty' => $qty);
//                $created_order_items = DB::table('orders_items')->insert($newOrderItem);
//            }
//            Session::forget('cart');
//            Session::flush();
//            return redirect()->route("homepage")->with('success','Thanks For Choosing us');
//
//        } else {
//            return redirect()->route("homepage")->with('success','Nothing in curt');
//        }
//    }
//



//    public function searchq($request)
//    {
//        $searchText = $request;
//        $products = Product::where('Name', 'Like', "%" . $searchText . "%")->
//        orWhere('type1', 'LIKE', '%' . $searchText . '%')->
//        orWhere('type2', 'LIKE', '%' . $searchText . '%')->
//        orWhere('type3', 'LIKE', '%' . $searchText . '%')->paginate(24);
//        return $products;
//    }


    function fetchs(Request $request)
    {
        if ($request->get('query')) {
            $searchText = $request->get('query');
            $data =book::where('name', 'Like', "%" . $searchText . "%")->
                orWhere('author', 'LIKE', '%' . $searchText . '%')->
                orWhere('publisher', 'LIKE', '%' . $searchText . '%')->
                orWhere('category', 'LIKE', '%' . $searchText . '%')->get();


            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            if ($searchText != null) {

                foreach ($data as $row) {
                    $image = url('/storage/product_images/' . $row->image);
                    $output .= <<<EOT
                     <li style="padding: 0 50px;"> <div  style=" display: flex; align-items: center;  flex-direction: row;"><a href="bookname/$row->slug" style="font-size: 1em;color: #0f0f0f;">
                      <img style="width:150px" src="$image"> $row->name  </a></div></li>
                    EOT;
                }
                $output .= '</ul>';

                echo $output;
            }
        } else {
            echo '';
        }
    }


}
