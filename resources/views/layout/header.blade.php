<div id="header">
    <div class="header-top">
        <div class="container">
            <div class="pull-left auto-width-left">
                <ul class="top-menu menu-beta l-inline">
                    <li><a href=""><i class="fa fa-home"></i> 90-92 Lê Thị Riêng, Bến Thành, Quận 1</a></li>
                    <li><a href=""><i class="fa fa-phone"></i> 0163 296 7751</a></li>
                </ul>
            </div>
            <div class="pull-right auto-width-right">
                <ul class="top-details menu-beta l-inline">
                    @if(Auth::check())
                        <li><a href="#"><i class="fa fa-user"></i>Xin chào {{ Auth::user()->full_name }}</a></li>
                        <li><a href="{{ route('logout') }}">Đăng xuất</a></li>
                    @else
                        <li><a href="#"><i class="fa fa-user"></i>Tài khoản</a></li>
                        <li><a href="{{ route('signUp') }}">Đăng kí</a></li>
                        <li><a href="{{ route('login') }}">Đăng nhập</a></li>
                    @endif
                </ul>
            </div>
            <div class="clearfix"></div>
        </div> <!-- .container -->
    </div> <!-- .header-top -->
    <div class="header-body">
        <div class="container beta-relative">
            <div class="pull-left">
                <a href="{{ route('index') }}" id="logo"><img src="/source/assets/dest/images/logo-cake.png" width="200px" alt=""></a>
            </div>
            <div class="pull-right beta-components space-left ov">
                <div class="space10">&nbsp;</div>
                <div class="beta-comp">
                    <form role="search" method="get" id="searchform" action="/">
                        <input type="text" value="" name="s" id="s" placeholder="Nhập từ khóa..." />
                        <button class="fa fa-search" type="submit" id="searchsubmit"></button>
                    </form>
                </div>

                <div class="beta-comp">
                    <div class="cart">
                        <div class="beta-select"><i class="fa fa-shopping-cart"></i> Giỏ hàng ({{ Session::has('cart') ? Session('cart')->totalQty:'Trống' }}) <i class="fa fa-chevron-down"></i></div>
                        @if(Session::has('cart'))
                        <div class="beta-dropdown cart-body">
                            @foreach($productCarts as $product)
                            <div class="cart-item">
                                <a class="cart-item-delete" href="{{ route('delCart', $product['item']['id'] ) }}"><i class="fa fa-times"></i></a>
                                <div class="media">
                                    <a class="pull-left" href="#"><img src="/source/image/product/{{ $product['item']['image'] }}" alt=""></a>
                                    {{-- Vì cái trỏ tới items có phần tử item là một đối tượng nên cân phải trỏ đến item rồi mới đến thuộc tính của item --}}
                                    <div class="media-body">
                                        <span class="cart-item-title">{{ $product['item']['name'] }}</span>
                                        <span class="cart-item-options">Size: XS; Colar: Navy</span>
                                        <span class="cart-item-amount">{{ $product['qty']}}*<span>${{ $product['item']['promotion_price'] == 0 ?
                                        number_format($product['item']['unit_price']):
                                        number_format($product['item']['promotion_price']) }}</span></span>
                                    </div>
                                </div>
    
                            </div>
                            @endforeach

                            <div class="cart-caption">
                                <div class="cart-total text-right">Tổng tiền: <span class="cart-total-value"> $ {{ number_format($cart->totalPrice) }}</span></div>
                                <div class="clearfix"></div>

                                <div class="center">
                                    <div class="space10">&nbsp;</div>
                                    <a href="{{route('checkOut')}}" class="beta-btn primary text-center">Đặt hàng <i class="fa fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                    </div> <!-- .cart -->

                </div>
                <div class="beta-comp">
                    @if(isset($wishlists))
                    <div class="dropdown">
                      <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-heart"></i> Wishlist (@if(isset($wishlists)&&count($wishlists)>0){{$sumWishlist}}@else
                        Trống @endif)
                      </button>
          
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <div class="dropdown-item">
                          @for($i = 0; $i< count($wishlists);$i++) <div class="cart-item"
                            id="cart-item{{$productsInWishlist[$i]->id}}">
                            <a class="cart-item-delete" href="/wishlist/delete/{{$wishlists[$i]->id}}"><i
                                class="fa fa-times"></i></a>
                            <div class="media">
                              <a class="pull-left" href="#"><img src="source/image/product/{{$productsInWishlist[$i]->image}}"
                                  alt="product"></a>
                              <div class="media-body">
                                <span class="cart-item-title">{{$productsInWishlist[$i]->name}}</span>
                                <span class="cart-item-amount">{{$wishlists[$i]->quantity}}*<span
                                    id="dongia{{$productsInWishlist[$i]->id}}">@if($productsInWishlist[$i]->promotion_price==0){{number_format($productsInWishlist[$i]->unit_price)}}@else
                                    {{ number_format($productsInWishlist[$i]->promotion_price) }}@endif</span></span>
                              </div>
                            </div>
                        </div>
                        @endfor
                      </div>
          
                      <div class="dropdown-item">
                        <div class="cart-caption">
                          <div class="cart-total text-right">Tổng tiền: <span
                              class="cart-total-value">@if(isset($wishlists)){{ number_format($totalWishlist) }}@else
                              0 @endif đồng</span></div>
                          <div class="clearfix"></div>
          
                          <div class="center">
                            <div class="space10">&nbsp;</div>
                            <a href="/wishlist/order" class="beta-btn primary text-center">Đặt hàng <i
                                class="fa fa-chevron-right"></i></a>
                          </div>
                        </div>
                      </div>
          
                    </div>
                    @endif
                  </div>
            </div>
            <div class="clearfix"></div>
        </div> <!-- .container -->
    </div> <!-- .header-body -->
    <div class="header-bottom" style="background-color: #0277b8;">
        <div class="container">
            <a class="visible-xs beta-menu-toggle pull-right" href="#"><span class='beta-menu-toggle-text'>Menu</span> <i class="fa fa-bars"></i></a>
            <div class="visible-xs clearfix"></div>
            <nav class="main-menu">
                <ul class="l-inline ov">
                    <li><a href="{{ route('index') }}">Trang chủ</a></li>
                    <li><a href="#">Sản phẩm</a>
                        <ul class="sub-menu">
                            @foreach($producttypes as $type)
                            <li><a href="{{route('productsByType',$type->id)}}">{{$type->name}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="#">Giới thiệu</a></li>
                    <li><a href="#">Liên hệ</a></li>
                </ul>
                <div class="clearfix"></div>
            </nav>
        </div> <!-- .container -->
    </div> <!-- .header-bottom -->
</div> <!-- #header -->