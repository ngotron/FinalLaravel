<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Support\Facades\Route;

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

// Route::get('/product', function () {
//     return view('page.typeproduct');
// });
Route::get('/', [ProductController::class, 'homepage'])->name('homepage');
Route::get('/typepro/{id}', [ProductController::class, 'showTypePro'])->name('typeProduct');
Route::get('/aboutUs', [ProductController::class, 'AboutUs'])->name("aboutUs");
Route::get('/contactUs', [ProductController::class, 'ContactUs'])->name('contactUs');
Route::get('/detail/{id}', [ProductController::class, 'detail'])->name('detail');
Route::get('/addtocart/{id}', [ProductController::class, 'addToCart'])->name('adtocart');
Route::get('/deleteCart/{id}', [ProductController::class, 'deleteCart'])->name('deleteCart');
Route::get('/checkout', [ProductController::class, 'showCheckout'])->name('showCheckout');
Route::post('/checkout', [ProductController::class, 'checkout'])->name('showCheckout');
Route::get('/signup', [ProductController::class, 'showSignup'])->name('showSignup');
Route::post('/signup', [ProductController::class, 'signup'])->name('showSignup');
Route::get('/signin', [ProductController::class, 'showSignin'])->name('showSignin');
Route::post('/signin', [ProductController::class, 'signin'])->name('showSignin');
Route::get('/logout', [ProductController::class, 'logout'])->name('logout');
Route::post('/vnpay/createPayment', [ProductController::class, 'checkout'])->name('postCreatePayment');
Route::get('/vnpayReturn', [ProductController::class, 'vnpayReturn'])->name('vnpayReturn');
Route::post('/vnpay/createPayment', [ProductController::class, 'createPayment'])->name('postCreatePayment');
Route::get('/inputEmail', [ProductController::class, 'InputEmail'])->name('InputEmail');
Route::post('/inputEmail', [ProductController::class, 'postInputEmail'])->name('postInputEmail');

// route:addmin

Route::get('/admin', [ProductController::class, 'getTable'])->name('admin');
Route::get('/showAddAdmin', [ProductController::class, 'showAddAdmin'])->name('showAddAdmin');
Route::post('/showAddAdmin', [ProductController::class, 'AddAdmin'])->name('showAddAdmin');
Route::get('/showEditAdmin/{id}', [ProductController::class, 'showEditAdmin'])->name('showEditAdmin');
Route::post('/updateEditAdmin/{id}', [ProductController::class, 'EditAdmin'])->name('updateEditAdmin');
Route::delete('/DeltetetAdmin/{id}', [ProductController::class, 'delete'])->name('DeltetetAdmin');


Route::get('/add/{id}', [WishlistController::class, 'AddWishlist'])->name('AddWishlist');
Route::delete('/delete/{id}', [WishlistController::class, 'DeleteWishlist'])->name('DeleteWishlist');
Route::get('/order', [WishlistController::class, 'OrderWishlist']);

Route::post('/comment/{id}', [ProductController::class, 'AddComment'])->name('AddComment');
Route::delete('/DeltetetComment/{id}', [ProductController::class, 'deleteComment'])->name('deleteComment');
