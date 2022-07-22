@extends('layout.master')
@section('content')
<div class="rev-slider">
	<div class="fullwidthbanner-container">
					<div class="fullwidthbanner">
						<div class="bannercontainer" >
					    <div class="banner" >
                            @if(isset($slides))
                                <ul>
                                    <!-- THE FIRST SLIDE -->
                                    @foreach($slides as $slide)
                                        <li data-transition="boxfade" data-slotamount="20" class="active-revslide" style="width: 100%; height: 100%; overflow: hidden; z-index: 18; visibility: hidden; opacity: 0;">
                                            <div class="slotholder" style="width:100%;height:100%;" data-duration="undefined" data-zoomstart="undefined" data-zoomend="undefined" data-rotationstart="undefined" data-rotationend="undefined" data-ease="undefined" data-bgpositionend="undefined" data-bgposition="undefined" data-kenburns="undefined" data-easeme="undefined" data-bgfit="undefined" data-bgfitend="undefined" data-owidth="undefined" data-oheight="undefined">
                                                <div class="tp-bgimg defaultimg" data-lazyload="undefined" data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat" data-lazydone="undefined" src="source/image/slide/{{$slide->image}}" data-src="source/image/slide/{{$slide->image}}" style="background-color: rgba(0, 0, 0, 0); background-repeat: no-repeat; background-image: url('source/image/slide/{{$slide->image}}'); background-size: cover; background-position: center center; width: 100%; height: 100%; opacity: 1; visibility: inherit;">
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
							</div>
						</div>

						<div class="tp-bannertimer"></div>
					</div>
				</div>
				<!--slider-->
	</div>
	<div class="container">
			{{-- @if(Session::has('message'))
            	<div class="alert alert-success">{{ Session::get('message')}}</div>
            @endif --}}
		<div id="content" class="space-top-none">

			<div class="main-content">
				<div class="space60">&nbsp;</div>
				<div class="row">
					<div class="col-sm-12">
                        @if( isset($new_products) )
                        <div class="beta-products-list">
							<h4>New Products</h4>
							<div class="beta-products-details">
								<p class="pull-left">438 styles found</p>
								<div class="clearfix"></div>
							</div>

							<div class="row">
                                @foreach($new_products as $new)
                                <div class="col-sm-3">
									<div class="single-item">
										<div class="single-item-header">
											<a href="product.html"><img src="source/image/product/{{ $new->image }}" alt="" style="width: 15rem;height:15rem"></a>
										</div>
										<div class="single-item-body">
											<p class="single-item-title">{{ $new->name }}</p>
											<p class="single-item-price">
                                                @if( $new->promotion_price != 0 )
												<span class="flash-del">${{ $new->unit_price }}</span>
												<span class="flash-sale">${{ $new->promotion_price }}</span>
                                                @else
                                                <span>${{ $new->unit_price }}</span>
                                                @endif
											</p>
										</div>
										<div class="single-item-caption">
											<a class="add-to-cart pull-left" href="{{ route('banhang.addtocart',$new->id) }}"><i class="fa fa-shopping-cart"></i></a>
											<a class="beta-btn primary" href="product.html">Details <i class="fa fa-chevron-right"></i></a>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
                                @endforeach
                                {{ $new_products->links() }}
								
							</div>
						</div> <!-- .beta-products-list -->
                        @endif
						

						<div class="space50">&nbsp;</div>
                        @if( isset($products) )
                        <div class="beta-products-list">
							<h4>All Products</h4>
							<div class="beta-products-details">
								<p class="pull-left">438 styles found</p>
								<div class="clearfix"></div>
							</div>
                            
                            <div class="row">
                                @foreach( $products as $pro )
								<div class="col-sm-3">
									<div class="single-item">
										<div class="ribbon-wrapper"><div class="ribbon sale">Sale</div></div>

										<div class="single-item-header">
											<a href="product.html"><img src="source/image/product/{{ $pro->image }}" alt="" style="width:15rem;height:15rem"></a>
										</div>
										<div class="single-item-body">
											<p class="single-item-title">{{ $pro->name }}</p>
											<p class="single-item-price">
												@if($new->promotion_price != 0)
												<span class="flash-del">${{ $new->unit_price }}</span>
												<span class="flash-sale">${{ $new->promotion_price }}</span>
                                                @else
                                                <span>${{$new->unit_price}}</span>
                                                @endif
											</p>
										</div>
										<div class="single-item-caption">
											<a class="add-to-cart pull-left" href="{{ route('banhang.addtocart',$pro->id) }}"><i class="fa fa-shopping-cart"></i></a>
											<a class="beta-btn primary" href="product.html">Details <i class="fa fa-chevron-right"></i></a>
											<div class="clearfix"></div>
										</div>
                                        <hr>
									</div>
								</div>
                                @endforeach
                                {{ $products->links() }}
							</div>
                            
							
							{{-- <div class="space40">&nbsp;</div> --}}
                            
						</div> <!-- .beta-products-list -->
                        @endif
						
					</div>
				</div> <!-- end section with sidebar and main content -->


			</div> <!-- .main-content -->
		</div> <!-- #content -->
	</div> <!-- .container -->
</div>
@endsection