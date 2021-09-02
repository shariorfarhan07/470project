<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/









Route::get('/admin', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    redirect()->route('adminorders');
})->middleware(['auth', 'verified'])->name('dashboard');


//Route::get('d',['uses'=>"App\Http\Controllers\ProductController@index"]);
//Route::get('dd' ,[\App\Http\Controllers\ProductController::class, 'index',]);

//admin_view
$admin="App\Http\Controllers\AdminController@";
// views
//Route::get('c',['uses'=>$admin."addbooks",'as'=>'adminaddbooks']);
Route::get('admin/booklist',['uses'=>$admin."bookslist",'as'=>'bookslist'])->middleware('auth');
Route::get('admin/orders',['uses'=>$admin."order",'as'=>'adminorders'])->middleware('auth');
// data recive


Route::post('admin/sendaddbook',['uses'=> $admin.'sendnewbook','as'=>'sendnewbook']);
Route::get('admin/addbook',['uses'=> $admin.'addbooks','as'=>'adminaddbooks'])->middleware('auth');
Route::post('admin/sendupdatebook/{id}',['uses'=> $admin.'sendupdatebook','as'=>'sendupdatebook']);
Route::get('admin/sendupdatebookid/{id}',['uses'=> $admin.'sendupdatebookview','as'=>'updatebook'])->middleware('auth');
Route::get('admin/deletebook/{id}',['uses'=> $admin.'deleteBook','as'=>'deleteBook'])->middleware('auth');
Route::post('sendmail',['uses'=>$admin.'mailorder','as'=> 'mailpdf']);
Route::get('printpdftobookinbd',['uses'=>$admin.'pdf','as'=> 'pdf']);

// user part
$book="App\Http\Controllers\ProductController@";
// index route
Route::get('/',['uses'=>$book."index",'as'=>'home']);// index page done need testing
// for index and shop grid
Route::get('books/{category}',['uses'=>$book."category",'as'=>'category']);// see more need testing
// add to cart remove from cart
Route::get('addtocart/{id}',['uses'=>$book."AddToCartProduct",'as'=>'add']);
Route::get('product/{id}/{number}',['uses'=> $book.'adjustcart','as'=>'adjustCart']);
Route::get('removefromcart/{id}/{number}',['uses'=>$book."adjustcart",'as'=>'remove']);


Route::post('/fetchs', $book.'fetchs')->name('fetchs');





//book view
Route::get('bookname/{slug}',['uses'=>$book."slugview",'as'=>'books']); // book views need testing
Route::get('search',['uses'=>$book."search",'as'=>'search']); //for search undone need testing

Route::get('placeorder',['uses'=>$book."orderview",'as'=>'order']); //returns oder from
Route::post('sendorder',['uses'=>$book."sendorder",'as'=>'sendorder']); // saves order to database
Route::get('cart',['uses'=>$book."cartview",'as'=>'cart']);

// need to migrate and test all the page and  finish ajax  and test  admin part
Route::get('logout',['uses'=>$book."logout",'as'=>'logoutt']);



//TestForm
Route::post('test111',function (Request $request){
 $categoryt= ($request->all())['category'];
 $str="";
 foreach ($categoryt as $t ){
     $str=$str.' '.$t;
    }
 return $str;

})->name('test');



Route::get('t',function (Request $request){
    return view('main.test');
});



require __DIR__.'/auth.php';
