@extends('layouts.frontLayout.front_design')
@section('content')

  <!-- slider-section-start -->
  <div class="main-slider-one main-slider-two slider-area">
			<div id="wrapper">
				<div class="slider-wrapper">
					<div id="mainSlider" class="nivoSlider">
						<img src="{{ asset('images/frontend_images/slider/slider1.jpg') }}" alt="main slider" title="#htmlcaption"/>
						<img src="{{ asset('images/frontend_images/slider/slider2.jpg') }}" alt="main slider" title="#htmlcaption2"/>
					</div>
				</div>							
			</div>
		</div>
        <!-- slider section end -->
        
<!-- featured-products section start -->
<section class="single-products  products-two section-padding extra-padding-bottom">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="section-title text-center">
							<h2>Tavsiya qilingan mahsulotlar</h2>
						</div>
					</div>
				</div>
				<div class="wrapper">
					<ul class="load-list load-list-one">
						<li>
							<div class="row text-center">
                                @foreach($featured as $product)
								<div class="col-xs-12 col-sm-6 col-md-3" style="padding-top: 30px;">
									<div class="single-product">
										<div class="product-img">
											<!-- <div class="pro-type">
												<span>new</span>
											</div> -->
											<a href="{{ url('product/'.$product->id) }}"><img src="{{ asset('images/backend_images/products/medium/'.$product->image) }}" alt="Product Title" /></a>
											<div class="actions-btn">
												<a href="{{ url('product/'.$product->id) }}"><i class="mdi mdi-cart"></i></a>
												<a href="{{ url('product/'.$product->id) }}" data-target="#quick-view"><i class="mdi mdi-eye"></i></a>
												<a href="{{ url('product/'.$product->id) }}"><i class="mdi mdi-heart"></i></a>
											</div>
										</div>
										<div class="product-dsc">
											<p><a href="{{ url('product/'.$product->id) }}">{{ $product->product_name }}</a></p>
											<span>{{ $product->price }} so'm</span>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</li>
					</ul>
				</div>
			</div>
		</section>
		<!-- featured-products section end -->
        <!-- tab-products section start -->
		<div class="tab-products single-products products-two section-padding extra-padding-top">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="section-title text-center">
							<div class="product-tab nav nav-tabs">
								<ul>
									<li class="active"><a data-toggle="tab" href="#arrival">Yangi mahsulotlar <span>//</span></a></li>
									<li><a data-toggle="tab" href="#popular">Ommabop mahsulotlar <span>//</span></a></li>
									<li><a data-toggle="tab" href="#best">Ko'p sotilgan mahsulotlar</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="text-center tab-content">
					<div class="tab-pane  fade in active" id="arrival">
						<div class="wrapper">
							<ul class="load-list">
								<li>
									<div class="row text-center">
									@foreach($new as $product)
								<div class="col-xs-12 col-sm-6 col-md-3" style="padding-top: 30px;">
									<div class="single-product">
										<div class="product-img">
											<!-- <div class="pro-type">
												<span>new</span>
											</div> -->
											<a href="{{ url('product/'.$product->id) }}"><img src="{{ asset('images/backend_images/products/medium/'.$product->image) }}" alt="Product Title" /></a>
											<div class="actions-btn">
												<a href="{{ url('product/'.$product->id) }}"><i class="mdi mdi-cart"></i></a>
												<a href="{{ url('product/'.$product->id) }}" data-target="#quick-view"><i class="mdi mdi-eye"></i></a>
												<a href="{{ url('product/'.$product->id) }}"><i class="mdi mdi-heart"></i></a>
											</div>
										</div>
										<div class="product-dsc">
											<p><a href="{{ url('product/'.$product->id) }}">{{ $product->product_name }}</a></p>
											<span>{{ $product->price }} so'm</span>
										</div>
									</div>
								</div>
								@endforeach
									</div>
								</li>
							</ul>
						</div>
					</div>
					<!-- arrival product end -->
					<div class="tab-pane fade" id="popular">
						<div class="wrapper">
							<ul class="load-list load-list-three">
								<li>
									<div class="row text-center">
									@foreach($popular as $product)
								<div class="col-xs-12 col-sm-6 col-md-3" style="padding-top: 30px;">
									<div class="single-product">
										<div class="product-img">
											<!-- <div class="pro-type">
												<span>new</span>
											</div> -->
											<a href="{{ url('product/'.$product->id) }}"><img src="{{ asset('images/backend_images/products/medium/'.$product->image) }}" alt="Product Title" /></a>
											<div class="actions-btn">
												<a href="{{ url('product/'.$product->id) }}"><i class="mdi mdi-cart"></i></a>
												<a href="{{ url('product/'.$product->id) }}" data-target="#quick-view"><i class="mdi mdi-eye"></i></a>
												<a href="{{ url('product/'.$product->id) }}"><i class="mdi mdi-heart"></i></a>
											</div>
										</div>
										<div class="product-dsc">
											<p><a href="{{ url('product/'.$product->id) }}">{{ $product->product_name }}</a></p>
											<span>{{ $product->price }} so'm</span>
										</div>
									</div>
								</div>
								@endforeach
									</div>
								</li>
							</ul>
						</div>
					</div>
					<!-- popular product end -->
					<div class="tab-pane fade" id="best">
						<div class="wrapper">
							<ul class="load-list load-list-four">
								<li>
									<div class="row text-center">
									@foreach($best as $product)
								<div class="col-xs-12 col-sm-6 col-md-3" style="padding-top: 30px;">
									<div class="single-product">
										<div class="product-img">
											<!-- <div class="pro-type">
												<span>new</span>
											</div> -->
											<a href="{{ url('product/'.$product->id) }}"><img src="{{ asset('images/backend_images/products/medium/'.$product->image) }}" alt="Product Title" /></a>
											<div class="actions-btn">
												<a href="{{ url('product/'.$product->id) }}"><i class="mdi mdi-cart"></i></a>
												<a href="{{ url('product/'.$product->id) }}" data-target="#quick-view"><i class="mdi mdi-eye"></i></a>
												<a href="{{ url('product/'.$product->id) }}"><i class="mdi mdi-heart"></i></a>
											</div>
										</div>
										<div class="product-dsc">
											<p><a href="{{ url('product/'.$product->id) }}">{{ $product->product_name }}</a></p>
											<span>{{ $product->price }} so'm</span>
										</div>
									</div>
								</div>
								@endforeach
									</div>
								</li>
							</ul>
						</div>
					</div>
					<!-- popular product end -->
				</div>
			</div>
		</div>
		<!-- tab-products section end -->

@endsection