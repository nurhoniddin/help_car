@extends('layouts.frontLayout.front_design')
@section('content')

        <!-- pages-title-start -->
		<div class="pages-title section-padding">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="pages-title-text text-center">
							<h2>{{ $productDetails->product_name }}</h2>
							<!-- <ul class="text-left">
								<li><a href="index.html">Home </a></li>
								<li><span> // </span><a href="shop.html">shop </a></li>
								<li><span> // </span>men’s white t-shirt</li>
							</ul> -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- pages-title-end -->
        <!-- product-details-section-start -->
		<div class="product-details pages section-padding-top">
			<div class="container">
				<div class="row">
                @if(Session::has('flash_message_error')) 
                <div class="alert alert-success alert-block">
                    <button  type="button" class="close" data-dismiss="alert">x</button>
                    <strong> {!! session('flash_message_error') !!}</strong>
                </div>
                @endif  
                @if(Session::has('flash_message_success')) 
                <div class="alert alert-success alert-block">
                    <button  type="button" class="close" data-dismiss="alert">x</button>
                    <strong> {!! session('flash_message_success') !!}</strong>
                </div>
                @endif 
					<div class="single-list-view">
						<div class="col-xs-12 col-sm-5 col-md-4">
							<div class="quick-image">
								<div class="single-quick-image text-center">
									<div class="list-img">
										<div class="product-img tab-content">
											<div class="simpleLens-container tab-pane active fade in" id="sin-1">
												<a href="{{ asset('images/backend_images/products/large/'.$productDetails->image) }}" class="highslide" onclick="return hs.expand(this)"><img src="{{ asset('images/backend_images/products/large/'.$productDetails->image) }}" alt="" class="simpleLens-big-image"></a>
											</div>
										</div>
									</div>
								</div>
								<div class="quick-thumb">
									<ul class="product-slider">
                                        <li class="active"><a href="{{ asset('images/backend_images/products/large/'.$productDetails->image) }}" class="highslide" onclick="return hs.expand(this)" role="tab" data-toggle="tab"> <img src="{{ asset('images/backend_images/products/small/'.$productDetails->image) }}" alt="small image" /> </a></li>
                                        <?php 
                                            $i = 2;
                                        ?>
                                        @foreach($productAltImages as $altimage)
                                        <li><a href="{{ asset('images/backend_images/products/large/'.$altimage->image) }}" class="highslide" onclick="return hs.expand(this)" role="tab" data-toggle="tab"> <img src="{{ asset('images/backend_images/products/small/'.$altimage->image) }}" alt="small image" /> </a></li>
                                        <?php
                                            $i++;
                                        ?>
                                        @endforeach
									</ul>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-7 col-md-8">
							<div class="quick-right">
								<div class="list-text">
									<h3>{{ $productDetails->product_name }}</h3>
									<!-- <div class="ratting floatright">
										<p>( 27 Rating )</p>
										<i class="mdi mdi-star"></i>
										<i class="mdi mdi-star"></i>
										<i class="mdi mdi-star"></i>
										<i class="mdi mdi-star-half"></i>
										<i class="mdi mdi-star-outline"></i>
									</div> -->
									<h5> {{ $productDetails->price}}  <span style="font-size: 17px; text-transform: lowercase; color: #333;"> so'm / dona</span></h5>
                                    <h5> {{ $productDetails->price_two }} <span style="font-size: 17px; text-transform: lowercase; color: #333;"> so'm / optim</span></h5>
                                    @foreach($productDetails->attributes as $name)
                                    <p>{{ $name->name}} _______________ {{ $name->description}}</p>
                                    @endforeach
                                    <form name="addtocartForm" id="addtocartForm" action="{{ url('add-cart') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="product_id" value="{{ $productDetails->id }}">
                                    <input type="hidden" name="product_name" value="{{ $productDetails->product_name }}">
                                    <input type="hidden" name="price" id="price" value="{{ $productDetails->price }}">
									<div class="all-choose" style="padding-top: 50px;">
										<div class="s-shoose">
											<h5></h5>
												<div class="plus-minus">
													<a class="dec qtybutton">-</a>
													<input type="text" value="1" name="quantity" class="plus-minus-box">
													<a class="inc qtybutton">+</a>
												</div>
										</div>
									</div>
									<div class="list-btn">
                                        <button type="submit" name="cartButton" value="Add to Cart">
                                            Savatga qo'shish
                                        </button>
                                        <button type="submit" name="wishListButton" value="Wish List">
                                            Saralanganlarga
                                        </button>
                                    </div>
                                    </form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- single-product item end -->
				<!-- reviews area start -->
				<div class="row">
					<div class="col-xs-12">
						<div class="reviews padding60 margin-top">
							<ul class="reviews-tab clearfix">
								<li class="active"><a data-toggle="tab" href="#moreinfo">Tavsif</a></li>
							</ul>
							<div class="tab-content">
								<div class="info-reviews moreinfo tab-pane fade in active" id="moreinfo">
									<p>{{ $productDetails->description}}</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- reviews area end -->
			</div>
		</div>
		<!-- product-details section end -->
        <!-- related-products section start -->
		<section class="single-products section-padding">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="section-title text-center">
							<h2>Yangi mahsulotlar</h2>
						</div>
					</div>
				</div>
				<div class="row text-center">
                    @foreach($relatedProducts as $item)
					<div class="col-xs-12 col-sm-6 col-md-3">
						<div class="single-product">
							<div class="product-img">
								<div class="pro-type">
								</div>
								<a href="{{ url('product/'.$item->id) }}"><img src="{{ asset('images/backend_images/products/medium/'.$item->image) }}" alt="Product Title" /></a>
								<div class="actions-btn">
									<a href="{{ url('product/'.$item->id) }}"><i class="mdi mdi-cart"></i></a>
									<a href="{{ url('product/'.$item->id) }}" data-toggle="modal" data-target="#quick-view"><i class="mdi mdi-eye"></i></a>
									<a href="{{ url('product/'.$item->id) }}"><i class="mdi mdi-heart"></i></a>
								</div>
							</div>
							<div class="product-dsc">
								<p><a href="{{ url('product/'.$item->id) }}">{{ $item->product_name }}</a></p>
								<span>{{ $item->price }} so'm</span>
							</div>
						</div>
					</div>
                    <!-- single product end -->
                    @endforeach
				</div>
			</div>
		</section>
		<!-- related-products section end -->

		<script type="text/javascript" src="{{ asset('highslide/highslide-with-gallery.js') }}"></script>
  <link rel="stylesheet" type="text/css" href="{{ asset('highslide/highslide.css') }}" />
  <script type="text/javascript">
      hs.graphicsDir = '/highslide/graphics/';
      hs.align = 'center';
      hs.transitions = ['expand', 'crossfade'];
      hs.wrapperClassName = 'dark borderless floating-caption';
      hs.fadeInOut = true;
      hs.dimmingOpacity = .75;

      // Add the controlbar
      if (hs.addSlideshow) hs.addSlideshow({
          //slideshowGroup: 'group1',
          interval: 5000,
          repeat: false,
          useControls: true,
          fixedControls: 'fit',
          overlayOptions: {
              opacity: .6,
              position: 'bottom center',
              hideOnMouseOut: true
          }
      });
  </script>

@endsection