@extends('layout.master')
@section('content')
<div class="inner-header">
    <div class="container">
        <div class="pull-left">
            <h6 class="inner-title">Đặt hàng</h6>
        </div>
        <div class="pull-right">
            <div class="beta-breadcrumb">
                <a href="index.html">Trang chủ</a> / <span>Đặt hàng</span>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<div class="container">
    <div id="content">
        
        <form action="{{ route('checkOut') }}" method="post" class="beta-form-checkout">
            @csrf
            <div class="row">
                <div class="col-sm-6">
             
                    @if(Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success')}}</div>
                    @endif

                    <div class="form-block">
                        <label for="name">Họ tên*</label>
                        <input type="text" id="name" name="name" placeholder="Họ tên" required>
                    </div>
                    <div class="form-block">
                        <label>Giới tính </label>
                        <input id="gender" type="radio" class="input-radio" name="gender" value="nam" checked="checked" style="width: 10%"><span style="margin-right: 10%">Nam</span>
                        <input id="gender" type="radio" class="input-radio" name="gender" value="nữ" style="width: 10%"><span>Nữ</span>
                                    
                    </div>

                    <div class="form-block">
                        <label for="email">Email*</label>
                        <input type="email" name="email" id="email"required placeholder="expample@gmail.com">
                    </div>

                    <div class="form-block">
                        <label for="adress">Địa chỉ*</label>
                        <input type="text" id="address" name="address" placeholder="Street Address" required>
                    </div>
                    

                    <div class="form-block">
                        <label for="phone">Điện thoại*</label>
                        <input type="text" id="phone" name="phone_number" required>
                    </div>
                    
                    <div class="form-block">
                        <label for="notes">Ghi chú</label>
                        <textarea id="note" name="note"></textarea>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="your-order">
                        <div class="your-order-head"><h5>Đơn hàng của bạn</h5></div>

                        <div class="your-order-body" style="padding: 0px 10px">
                            @if(Session::has('cart'))
                            <div class="your-order-item">
                                <div>
                                <!--  one item	 -->
                                @foreach($productCarts as $pro)
                                    <div class="media">
                                        <img width="25%" src="/source/image/product/{{$pro['item']['image']}}" alt="" class="pull-left">
                                        <div class="media-body">
                                            <p class="font-large">{{$pro['item']['name']}}</p>
                                            <span class="color-gray your-order-info">{{$pro['item']['name']}}</span>
                                            <span class="cart-item-amount">{{ $pro['qty']}}*
                                                <span>${{ $pro['item']['promotion_price'] == 0 ? number_format($pro['item']['unit_price']): number_format($pro['item']['promotion_price']) }}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                                <!-- end one item -->
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            @endif
                            <div class="your-order-item">
                                <div class="pull-left"><p class="your-order-f18">Tổng tiền:</p></div>
                                <div class="pull-right"><h5 class="color-black">$ {{ Session::has('cart')? number_format($cart->totalPrice): '0'}}</h5></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        
                        <div class="your-order-head"><h5>Hình thức thanh toán</h5></div>
                        
                        <div class="your-order-body">
                            <ul class="payment_methods methods">
                                <li class="payment_method_bacs">
                                    <input id="payment_method_bacs" type="radio" class="input-radio" name="payment_method" value="COD" checked="checked" data-order_button_text="">
                                    <label for="payment_method_bacs">Thanh toán khi nhận hàng </label>
                                    <div class="payment_box payment_method_bacs" style="display: block;">
                                        Cửa hàng sẽ gửi hàng đến địa chỉ của bạn, bạn xem hàng rồi thanh toán tiền cho nhân viên giao hàng
                                    </div>						
                                </li>

                                <li class="payment_method_cheque">
                                    <input id="payment_method_cheque" type="radio" class="input-radio" name="payment_method" value="ATM" data-order_button_text="">
                                    <label for="payment_method_cheque">Chuyển khoản </label>
                                    <div class="payment_box payment_method_cheque" style="display: none;">
                                        Chuyển tiền đến tài khoản sau:
                                        <br>- Số tài khoản: 123 456 789
                                        <br>- Chủ TK: Nguyễn A
                                        <br>- Ngân hàng ACB, Chi nhánh TPHCM
                                    </div>						
                                </li>
                                
                            </ul>
                        </div>

                        <div class="text-center"><button type="submit">Đặt hàng</button></div>
                    </div> <!-- .your-order -->
                </div>
            </div>
        </form>
    </div> <!-- #content -->
</div> <!-- .container -->
@endsection