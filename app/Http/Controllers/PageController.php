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
    //Show ra trang chủ
    public function index(){
        $slides = Slide::all();
        $products = Product::paginate(8);
        $new_products = Product::where('new',1)->paginate(4);
        return view('banhang.index', compact('slides','products','new_products'));
    }

    //Show ra trang sản phẩm theo loại
    public function productsByType($type){
        $products_type_new = Product::where('id_type',$type)->where('new',1)->paginate(3);
        $products_type_all = Product::where('id_type',$type)->paginate(3);
        return view('banhang.product_type',compact('products_type_new','products_type_all'));
    }

    //Show ra trang chi tiết sản phẩm
    public function getDetail($id){
        $product = Product::find($id);
        return view('banhang.detail',compact('product'));
    }

    //Thêm vào giỏ hàng
    public function addToCart(Request $request,$id){
    	$product=Product::find($id);
    	$oldCart=Session('cart')? Session::get('cart'):null;
    	$cart=new Cart($oldCart);
    	$cart->add($product,$id);
    	$request->session()->put('cart',$cart);
    	return redirect()->back();
    }

    //Xóa khỏi giỏ hàng
    public function getDelCart($id){
        $oldCart=Session::has('cart')? Session::get('cart') : null;
        $cart=new Cart($oldCart);
        $cart->removeItem($id);
        Session::put('cart', $cart);
        return redirect()->back();
    }

    //Show ra trang check out
    public function getCheckOut(){
        return view('banhang.checkout');
    }

    
    public function postCheckout(Request $request)
    {
        if ($request->input('payment_method') != "VNPAY") {

            $cart = Session::get('cart');
            $customer = new Customer;
            $customer->name = $request->name;
            $customer->gender = $request->gender;
            $customer->email = $request->email;
            $customer->address = $request->address;
            $customer->phone_number = $request->phone_number;
            $customer->note = $request->note;
            $customer->save();

            $bill = new Bill;
            $bill->id_customer = $customer->id;
            $bill->date_order = date('Y-m-d');
            $bill->total = $cart->totalPrice;
            $bill->payment = $request->payment_method;
            $bill->note = $request->notes;
            $bill->save();

            foreach ($cart->items as $key => $value) {
                $bill_detail = new BillDetail;
                $bill_detail->id_bill = $bill->id;
                $bill_detail->id_product = $key;
                $bill_detail->quantity =  $value['qty'];
                $bill_detail->unit_price = ($value['price'] / $value['qty']);
                $bill_detail->save();
            }
        } else { //nếu thanh toán là vnpay
            $cart = Session::get('cart');
            return view('/vnpay/vnpay-index', compact('cart'));
        }
        Session::forget('cart');
        return redirect()->back()->with('thongbao', 'Đặt hàng thành công');
    }
    //Show ra trang đăng ký tài khoản
    public function getSignUp(){
        return view('banhang.signup');
    }

    //Đăng ký tài khoản
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

    //Show ra trang đăng nhập
    public function getLogin(){
        return view('banhang.login');
    }

    //Đăng nhập
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

    //Đăng xuất
    public function getLogout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index');
    }
    //hàm xử lý nút Xác nhận thanh toán trên trang vnpay-index.blade.php, hàm này nhận request từ trang vnpay-index.blade.php
    public function createPayment(Request $request){
        $cart=Session::get('cart');
        $vnp_TxnRef = $request->transaction_id; //Mã giao dịch. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = $request->order_desc;
        $vnp_Amount = str_replace(',', '', $cart->totalPrice * 100);
        $vnp_Locale = $request->language;
        $vnp_BankCode =$request->bank_code;
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        

        $vnpay_Data = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => env('VNP_TMNCODE'),
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_ReturnUrl" => route('vnpayReturn'),
            "vnp_TxnRef" => $vnp_TxnRef,
           
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $vnpay_Data['vnp_BankCode'] = $vnp_BankCode;
        }
        ksort($vnpay_Data);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($vnpay_Data as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = env('VNP_URL') . "?" . $query;
        if (env('VNP_HASHSECRECT')) {
   // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
            //$vnpSecureHash = hash('sha256', env('VNP_HASHSECRECT'). $hashdata);
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, env('VNP_HASHSECRECT'));//  
           // $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        //dd($vnp_Url);
        return redirect($vnp_Url);
        die();
    }

    //ham nhan get request tra ve tu vnpay
    public function vnpayReturn(Request $request){ 
        //dd($request->all());
        // if($request->vnp_ResponseCode=='00'){
        //     $secureHash = $request->query('vnp_SecureHash');
        //     if ($secureHash == env('VNP_HASHSECRECT')) {
        //      $cart=Session::get('cart');
            
        //      //lay du lieu vnpay tra ve
        //      $vnpay_Data=$request->all();

        //      //insert du lieu vao bang payments
        //      //.........

        //     //truyen vnpay_Data vao trang vnpay_return
        //     return view('vnpay_return',compact('vnpay_Data'));
        //     }
        // }
        //PHIEEN BAN 2022
    //ham nhan get request tra ve tu vnpay
    $vnp_SecureHash = $request->vnp_SecureHash;
           //echo $vnp_SecureHash;
           $vnpay_Data = array();
           foreach ($request->query() as $key => $value) {
               if (substr($key, 0, 4) == "vnp_") {
                   $vnpay_Data[$key] = $value;
               }
           }
           
           unset($vnpay_Data['vnp_SecureHash']);
           ksort($vnpay_Data);
           $i = 0;
           $hashData = "";
           foreach ($vnpay_Data as $key => $value) {
               if ($i == 1) {
                   $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
               } else {
                   $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                   $i = 1;
               }
           }
   
           $secureHash = hash_hmac('sha512', $hashData, env('VNP_HASHSECRECT'));
          // echo $secureHash;
          

           if ($secureHash == $vnp_SecureHash) {
                if ($request->query('vnp_ResponseCode') == '00') {
                    $cart=Session::get('cart');
                    //lay du lieu vnpay tra ve
                    $vnpay_Data=$request->all();

                    //insert du lieu vao bang payments
                    //.........

                    //truyen vnpay_Data vao trang vnpay_return
                    Session::forget('cart');
                    return view('/vnpay/vnpay-return',compact('vnpay_Data'));
                }
            }
    }
    public function getInputEmail(){
        return view('emails/input-email');
    }
    public function postInputEmail(Request $req){
        $email=$req->txtEmail;
        //validate

        // kiểm tra có user có email như vậy không
        $user=User::where('email',$email)->get();
        //dd($user);
        if($user->count()!=0){
            //gửi mật khẩu reset tới email
            $sentData = [
                'title' => 'Mật khẩu mới của bạn là:',
                'body' => '123456'
            ];
           \Mail::to($email)->send(new \App\Mail\SendMail($sentData));
            Session::flash('message', 'Send email successfully!');
            return view('emails/input-email');  //về lại trang đăng nhập của khách
        }
        else {
              return redirect()->route('getInputEmail')->with('message','Your email is not right');
        }
    }

}
