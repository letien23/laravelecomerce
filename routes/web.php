<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\WishlistController;

use App\Http\Controllers\CategoryController;
use App\Http\Middleware\AdminLoginMiddldeware;




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

//amdin
Route::get('/admin/login', [UserController::class, 'getLogin'])->name('admin.category.login');
Route::post('/admin/login', [UserController::class, 'postLogin'])->name('admin.category.login');
// Route::get('/admin/logout',[UserController::class,'getLogout'])->name('admin.category.logout');

Route::group(['prefix' => 'admin', 'middleware' => 'adminlogin'], function () {
    Route::group(['prefix' => 'category'], function () {
        // admin/category/danhsach
        Route::get('/category-list', [CategoryController::class, 'getCategoryList'])->name('admin.category-list');
        // Route::get('them',[CategoryController::class,'getCateAdd'])->name('admin.getCateAdd');
        // Route::post('them',[CategoryController::class,'postCateAdd'])->name('admin.postCateAdd');
        // Route::get('xoa/{id}',[CategoryController::class,'getCateDelete'])->name('admin.getCateDelete');
        // Route::get('sua/{id}',[CategoryController::class,'getCateEdit'])->name('admin.getCateEdit');
        // Route::post('sua/{id}',[CategoryController::class,'postCateEdit'])->name('admin.postCateEdit');
    });
});
Route::get('/category-add', [CategoryController::class , 'getAdminpage'])->name('add-product');
Route::post('/category-add', [CategoryController::class , 'postAdminAdd'])->name('add-product');
Route::get('/category-list',[CategoryController::class, 'getIndexAdmin'])->name('list-product');

// ---
Route::get('/admin-edit-form/{id}',[CategoryController::class,'getAdminEdit'])->name('get-edit-product');
Route::post('/admin-edit',[CategoryController::class,'postAdminEdit'])->name('edit-product');


Route::post('/admin-delete/{id}',[CategoryController::class,'postAdminDelete'])->name('post-delete-product');
//wishlist
Route::prefix('wishlist')->group(function () {
    Route::get('/add/{id}', [WishlistController::class, 'AddWishlist']);
    Route::get('/delete/{id}', [WishlistController::class, 'DeleteWishlist']);

    Route::get('/order', [WishlistController::class, 'OrderWishlist']);
});

//------------------------- Comment ---------------------------------//
Route::post('/comment/{id}', [CommentController::class, 'AddComment']);
