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
Route::get('/index',[PageController::class,'index']);
Route::get('/type/{id}',[PageController::class,'productsByType'])->name('productsByType');

Route::get('/add-to-cart/{id}',[PageController::class,'addToCart'])->name('banhang.addtocart');//Liên kết với nút hình giỏ hàng để thêm sảm phẩm vào giỏ hàng

// Route::get('/a', function () {
//     return view('banhang.product');
// });