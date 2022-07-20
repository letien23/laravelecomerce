<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Slide;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;




class PageController extends Controller
{
    public function index()
    {
        $slides = Slide::all();
        $products = Product::paginate(8);
        $new_products = Product::where('new',1)->paginate(4);
        return view('banhang.index', compact('slides','products','new_products'));
    }
    public function productsByType($type)
    {
        $products_type_new = Product::where('id_type',$type)->where('new',1)->paginate(3);
        $products_type_all = Product::where('id_type',$type)->paginate(3);
        return view('banhang.product_type',compact('products_type_new','products_type_all'));
    }
    public function addToCart(Request $request,$id){
    	$product=Product::find($id);
    	$oldCart=Session('cart')? Session::get('cart'):null;
    	$cart=new Cart($oldCart);
    	$cart->add($product,$id);
    	$request->session()->put('cart',$cart);
    	return redirect()->back();
    }

}
