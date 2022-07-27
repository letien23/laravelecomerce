<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

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

Route::get('/', function () {
    return view('welcome');
});
//Trang chu
Route::get('/index',[PageController::class,'index'])->name('index');
//Show sp theo loai
Route::get('/type/{id}',[PageController::class,'productsByType'])->name('productsByType');
//Show trang chi tiet san pham
Route::get('/detail/{id}',[PageController::class, 'getDetail'])->name('detail');
//Them vao gio hang
Route::get('/add-to-cart/{id}',[PageController::class,'addToCart'])->name('banhang.addtocart');//Liên kết với nút hình giỏ hàng để thêm sảm phẩm vào giỏ hàng
Route::get('/delcart/{id}',[PageController::class,'getDelCart'])->name('delCart');
//Checkout
Route::get('/checkout',[PageController::class,'getCheckOut'])->name('checkOut');
Route::post('/checkout',[PageController::class,'postCheckOut'])->name('checkOut');

//Signup & Login
Route::get('/signup',[PageController::class,'getSignUp'])->name('signUp');
Route::post('/signup',[PageController::class,'postSignUp'])->name('signUp');
Route::get('/login',[PageController::class,'getLogin'])->name('login');
Route::post('/login',[PageController::class,'postLogin'])->name('login');
Route::get('/logout',[PageController::class,'getLogout'])->name('logout');




Route::get('/a', function () {
    return view('banhang.detail');
});
Route::get('/b', function () {
    return view('admin.layoutadmin');
});

Route::get('/vnpay-index', function () {
    return view('/vnpay/vnpay-index');
});
// //Route xử lý nút Xác nhận thanh toán trên trang checkout.blade.php
Route::post('/vnpay/create_payment', [PageController::class, 'createPayment'])->name('postCreatePayment');
// //Route để gán cho key "vnp_ReturnUrl" ở bước 6
Route::get('/vnpay/vnpay_return', [PageController::class, 'vnpayReturn'])->name('vnpayReturn');

//email
Route::get('/input-email', [PageController::class,'getInputEmail'])->name('getInputEmail');
Route::post('/input-email',[PageController::class,'postInputEmail'])->name('postInputEmail');