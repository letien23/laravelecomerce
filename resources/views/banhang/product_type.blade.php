@extends('layout.master')
@section('content')
<div class="inner-header">
    <div class="container">
        <div class="pull-left">
            <h6 class="inner-title">Sản phẩm</h6>
        </div>
        <div class="pull-right">
            <div class="beta-breadcrumb font-large">
                <a href="index.html">Home</a> / <span>Sản phẩm</span>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="container">
    <div id="content" class="space-top-none">
        <div class="main-content">
            <div class="space60">&nbsp;</div>
            <div class="row">
                <div class="col-sm-3">
                    <ul class="aside-menu">
                        @foreach($producttypes as $type)
                        <li><a href="{{route('productsByType',$type->id)}}">{{$type->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-sm-9">
                    @if(isset($products_type_new))
                    <div class="beta-products-list">
                        <h4>New Products</h4>
                        <div class="beta-products-details">
                            <p class="pull-left">438 styles found</p>
                            <div class="clearfix"></div>
                        </div>

                        <div class="row">
                            @foreach($products_type_new as $ptn)
                            <div class="col-sm-4">
                                <div class="single-item">
                                    <div class="single-item-header">
                                        <a href="product.html"><img src="/source/image/product/{{$ptn->image}}" alt="" style="width:13rem; height:13rem"></a>
                                    </div>
                                    <div class="single-item-body">
                                        <p class="single-item-title">{{$ptn->name}}</p>
                                        <p class="single-item-price">
                                            @if($ptn->promotion_price != 0)
                                            <span class="flash-del">${{$ptn->unit_price}}</span>
                                            <span class="flash-sale">${{$ptn->promotion_price}}</span>
                                            @else
                                            <span>${{$ptn->unit_price}}</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="single-item-caption">
                                        <a class="add-to-cart pull-left" href="{{ route('banhang.addtocart',$ptn->id) }}"><i class="fa fa-shopping-cart"></i></a>
                                        <a class="beta-btn primary" href="{{ route('detail', $ptn->id) }}">Details <i class="fa fa-chevron-right"></i></a>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            {{ $products_type_new->links() }}
                            
                        </div>
                    </div> <!-- .beta-products-list -->
                    @endif
                    

                    <div class="space50">&nbsp;</div>
                    @if(isset($products_type_all))
                    <div class="beta-products-list">
                        <h4>Top Products</h4>
                        <div class="beta-products-details">
                            <p class="pull-left">438 styles found</p>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row">
                            @foreach($products_type_all as $pta)
                            <div class="col-sm-4">
                                <div class="single-item">
                                    <div class="single-item-header">
                                        <a href="product.html"><img src="/source/image/product/{{$pta->image}}" alt="" style="width:13rem; height:13rem"></a>
                                    </div>
                                    <div class="single-item-body">
                                        <p class="single-item-title">{{$pta->name}}</p>
                                        <p class="single-item-price">
                                            @if($pta->promotion_price != 0)
                                            <span class="flash-del">${{$pta->unit_price}}</span>
                                            <span class="flash-sale">${{$pta->promotion_price}}</span>
                                            @else
                                            <span>${{$pta->unit_price}}</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="single-item-caption">
                                        <a class="add-to-cart pull-left" href="{{ route('banhang.addtocart',$pta->id) }}"><i class="fa fa-shopping-cart"></i></a>
                                        <a class="beta-btn primary" href="{{ route('detail', $pta->id) }}">Details <i class="fa fa-chevron-right"></i></a>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                        </div>
                        <div class="space40">&nbsp;</div>
                        
                    </div> <!-- .beta-products-list -->
                    @endif
                    
                </div>
            </div> <!-- end section with sidebar and main content -->


        </div> <!-- .main-content -->
    </div> <!-- #content -->
</div> <!-- .container -->
@endsection