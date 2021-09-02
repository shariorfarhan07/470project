<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\Order;
use App\Models\orderlist;
use App\Orders_items;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function pdf(){
        return view('main.pdf');
    }
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

    public function addbooks(){
        return view('admin.addproduct');
    }

    public function bookslist(){
        $books=book::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.booklist',compact('books',$books));

    }
    public function order(){
        $order=Order::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.order',['orders'=>$order ]);
    }
    public function update($id){
        $book=book::find($id);
        return view('admin.update',['book'=>$book]);
    }

    private function slugg($formdata){
        $slug =$formdata['name'];
        $author=$formdata['author'];
        if($author!=""){
            $slug=$slug.' author: '.$author;
        }
        $author=$formdata['publisher'];
        if($author!=""){
            $slug=$slug.' publisher: '.$author;
        }
        return $slug;

    }
    public function sendnewbook(Request $request){
       $date=date('Y-m-d H:i:s');
        //$date=Carbon::createFromDate();

        // dd($date);
       // dd(implode(' ',$request->all()));
        Validator::make($request->all(),['image'=>"required|file|image|mimes:jpg,png,jpeg|max:2000"])->validate();
        $ext =$request->file('image')->getClientOriginalExtension();

//    making slug
        $formdata=$request->all();

        unset($formdata['_token']);
        $slug =$this->slugg($formdata).$date;
        $slug=Str::slug($slug,'-');

        $imageName=$slug;// add extention to the image
        $imageName=Str::slug($slug,'-').".".$ext;


        $imageEncoded=File::get($request->image);
        Storage::disk('local')->put('public\\product_images\\'.$imageName,$imageEncoded);
        unset($formdata['image']);
        $formdata += array("image" => $imageName,"slug" => $slug,"created_at" => $date,"updated_at" => $date);


        ///dd($formdata);
        $created=DB::table('books')->insert($formdata);

        if($created){
//            $id = DB::getPdo()->lastInsertId();;
            return redirect()->route('bookslist');

        }else{
            return 'new product was not created';

        }

    }

public function sendupdatebookview($id){
        $book=book::find($id);
        return view('admin.update',compact('book',$book));
}



    public function sendupdatebook(Request $request,$id){
      //  dd('$formdata');
        $date=date('Y-m-d H:i:s');
        // dd(implode(' ',$request->all()));3
        $formdata=$request->all();
        $product=book::find($id);

        unset($formdata['_token']);
        $slug =$this->slugg($formdata);
        $slug=Str::slug($slug,'-');
        $formdata += array("slug" => $slug,"updated_at" => $date);
        $created=DB::table('books')->where('id',$id)->update($formdata);

        if($created){
            $id = DB::getPdo()->lastInsertId();;
            return redirect()->route('bookslist');//book redirect
        }else{
            return 'new product was not created';

        }

    }







//not sure

    public function deleteBook($id){
        $product=book::find($id);
        $exists=Storage::disk("local")->exists('public\\product_images\\'.$product->image);
        //delete that image
        if($exists){
            $exists= Storage::delete('public\\product_images\\'.$product->image);
        }
        book::destroy($id);
        return redirect()->route('bookslist');
    }
//not sure
     public function ordernumber($id)
     {
         $order=orderlist::where('order_id',$id)->pluck('book_id');
         $books=book::where('id',$order)->get();
         $customer=order::where('id',$id)->get();
         return view('invoice')->with($books)->with($customer);
     }


    public function index(){
        $products = Product::orderBy('created_at', 'desc')->paginate(6);
        return view("admin.AdmindisplayProducts",['products'=>$products ]);
    }





    public function invoice($id){
        $products = Orders_Items::where('order_id', $id)->get();
        $userdetails=Order::find($id);
        return view("admin.invoice",['products'=>$products ,'customer'=>$userdetails]);
    }

    public function editProductForm($id){
        $product=Product::find($id);
        return view('admin.editProductForm',['product'=>$product]) ;
    }

    public function createProductForm(){
        return view('admin.createProductForm');
    }
    public function orderview(){
        return view('admin.order');
    }




    public function sendCreateProductForm(Request $request){
        $date=date('Y-m-d H:i:s');
        $name=$request->input('name');
        $description=$request->input('description');
        $price=$request->input('price');
        $stock=$request->input('stock');
        $type1=$request->input('type1');
        $type2=$request->input('type1');
        $type3=$request->input('type1');
        $slug=$request->input('slug');
        $ssdescription= $request->input('sdescription');
        $datasheet= $request->input('datasheet');
        $link= $request->input('link');

        Validator::make($request->all(),['image'=>"required|file|image|mimes:jpg,png,jpeg|max:2000"])->validate();
        $ext =$request->file('image')->getClientOriginalExtension();
        $stringImageReFormat=str_replace(' ','',$request->input('name'));
        $imageName=$stringImageReFormat.$date.".".$ext;// add extention to the image
        $imageEncoded=File::get($request->image);

        Storage::disk('local')->put('public/product_images/'.$imageName,$imageEncoded);
        $newProductArray=array('sdescription'=>$ssdescription,'datasheet'=>$datasheet,'link'=>$link,'Name'=>$name,'description'=>$description,'stock'=>$stock,'price'=>$price,'image'=>$imageName,'type1'=>$type1,'type2'=>$type2,'type3'=>$type3,'slug'=>$slug,'sold'=>0);
        $created=DB::table('products')->insert($newProductArray);

        if($created){
            $id = DB::getPdo()->lastInsertId();;
            return redirect()->url('productview/'.$id);

        }else{
            return 'new product was not created';

        }
    }

    public function updateProductImageForm(Request $request,$id){

        Validator::make($request->all(),['image'=>"required|file|image|mimes:jpg,png,jpeg|max:2000"])->validate();

        if($request->hasFile("image")){
            $product=Product::find($id);
            $exists=$product->image;
            try {
                if($exists){
                    $exists=Storage::disk("local")->exists('public/product_images/'.$product->image);
                }
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
            //delete that image
            if($exists){
                Storage::delete('public/product_images/'.$product->image1);
                $imageName=$product->image;
            }else{
                $ext =$request->file('image')->getClientOriginalExtension();
                $stringImageReFormat=str_replace(' ','',$request->input('name'));
                $imageName=$stringImageReFormat.".".$ext;// add extention to the image

            }
            // upload that image
            //$request->file('image')->getClientOriginalExtension();//return jpg

            $request->image->storeAs("public/product_images/",$imageName);
            $arrayToUpdate=array('image'=>$imageName);
            DB::table('books')->where('id',$id)->update($arrayToUpdate);
            return redirect()->route('adminDisplayProduct');
        }else{
            return 'no image was selected';
        }

    }



    public function updateProduct(Request $request,$id){
        $name=$request->input('name');
        $description=$request->input('description');
        $price=$request->input('price');
        $stock=$request->input('stock');
        $type1=$request->input('type1');
        $type2=$request->input('type2');
        $type3= $request->input('type3');
        $slug= $request->input('slug');
        $ssdescription= $request->input('sdescription');
        $datasheet= $request->input('datasheet');
        $link= $request->input('link');

        $arrayToUpdate=array('Name'=>$name,'description'=>$description,'stock'=>$stock,'price'=>$price,'type1'=>$type1,'type2'=>$type2,'type3'=>$type3,'slug'=>$slug,'sdescription'=>$ssdescription,'datasheet'=>$datasheet,'link'=>$link);
        DB::table('products')->where('id',$id)->update($arrayToUpdate);
        $id = DB::getPdo()->lastInsertId();
        return redirect()->route('adminDisplayProduct');

    }










}


