<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Slide;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Bill;
use App\Models\User;
use App\Models\BillDetail;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
    public function getDelCart($id)
    {
        $oldCart=Session::has('cart')? Session::get('cart') : null;
        $cart=new Cart($oldCart);
        $cart->removeItem($id);
        Session::put('cart', $cart);
        return redirect()->back();
    }
    public function getCheckOut()
    {
        return view('banhang.checkout');
    }
    public function postCheckout(Request $request){
        if($request->input('payment_method')!="VNPAY"){
            $cart=Session::get('cart');
            $customer=new Customer();
            $customer->name=$request->name;
            $customer->gender=$request->gender;
            $customer->email=$request->email;
            $customer->address=$request->address;
            $customer->phone_number=$request->phone_number;
            $customer->note=$request->note;
            $customer->save();
    
            $bill=new Bill();
            $bill->id_customer=$customer->id;
            $bill->date_order=date('Y-m-d');
            $bill->total=$cart->totalPrice;
            $bill->payment=$request->payment_method;
            $bill->note=$request->note;
            $bill->save();
    
            foreach($cart->items as $key=>$value)
            {
                $bill_detail=new BillDetail();
                $bill_detail->id_bill=$bill->id;
                $bill_detail->id_product=$key;
                $bill_detail->quantity=$value['qty'];
                $bill_detail->unit_price=$value['price']/$value['qty'];
                $bill_detail->save();
            }
            Session::forget('cart');
            return redirect()->back()->with('success','Đặt hàng thành công');
    
        }
        else {//nếu thanh toán là vnpay
            $cart=Session::get('cart');
            return view('/vnpay-index',compact('cart'));
        }
    }
    public function getSignUp()
    {
        return view('banhang.signup');
    }
    public function postSignUp(Request $request){
        $this->validate($request,
            [
                'email'=>'required|email|unique:users,email',
                'password'=>'required|min:6|max:20',
                'fullname'=>'required',
                're_password'=>'required|same:password'
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Không đúng định dạng email',
                'email.unique'=>'Email đã có người sử dụng',
                'password.required'=>'Vui long nhập mật khẩu',
                're_password.same'=>'Mật khẩu không giống nhau',
                'password.min'=>'Mật khẩu ít nhất 6 kí tự'

            ]);
        $user = new User();
        $user->full_name = $request->fullname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();
        return redirect()->back()->with('thanhcong','Tạo tài khoản thành công');
    }

    public function getLogin()
    {
        return view('banhang.login');
    }

    public function postLogin(Request $req){
        $this->validate($req,
        [
            'email'=>'required|email',
            'password'=>'required|min:6|max:20'
        ],
        [
            'email.required'=>'Vui lòng nhập email',
            'email.email'=>'Không đúng định dạng email',
            'password.required'=>'Vui lòng nhập mật khẩu',
            'password.min'=>'Mật khẩu ít nhất 6 ký tự',
            'password.max'=>'Mật khẩu tối đa 20 ký tự'
        ]
        );
        $credentials=['email'=>$req->email,'password'=>$req->password];
        if(Auth::attempt($credentials)){//The attempt method will return true if authentication was successful. Otherwise, false will be returned.
            return redirect('/index')->with(['flag'=>'alert','message'=>'Đăng nhập thành công']);
        }
        else{
            return redirect()->back()->with(['flag'=>'danger','message'=>'Đăng nhập không thành công']);
        }
    }
    public function getLogout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index');
    }

}
