@extends('layouts.frontLayout.front_design')
@section('content')

        <!-- pages-title-start -->
		<div class="pages-title section-padding">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="pages-title-text text-center">
							@if(!empty($search_product))
							   <h2> {{ $search_product }} </h2>
							@else
							   <h2> {{ $categoryDetails->name }} </h2>
							@endif
							<ul class="text-left">
								<!-- <li><a href="index.html">Home </a></li>
								<li><span> // </span>Shop</li> -->
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- pages-title-end -->
		<!-- shop content section start -->
		<div class="pages products-page section-padding text-center">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="right-products">
							<div class="row">
								<div class="col-xs-12">
									<div class="section-title clearfix">
										<ul>
											<li>
												<ul class="nav-view">
													<li><a href="#"> <i class="mdi mdi-view-list"></i> </a></li>
												</ul>
											</li>
											<li class="sort-by floatright">
												{{ count($productsAll) }} Natija
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="grid-content">
									@foreach($productsAll as $product)
									<div class="col-xs-12 col-sm-6 col-md-3">
										<div class="single-product">
											<div class="product-img">
												<div class="pro-type">
													<!-- <span>new</span> -->
												</div>
												<a href="{{ url('product/'.$product->id) }}"><img src="{{ asset('images/backend_images/products/medium/'.$product->image) }}" alt="Product Title" /></a>
												<div class="actions-btn">
													<a href="{{ url('product/'.$product->id) }}"><i class="mdi mdi-cart"></i></a>
													<a href="{{ url('product/'.$product->id) }}" data-toggle="modal" data-target="#quick-view"><i class="mdi mdi-eye"></i></a>
													<a href="{{ url('product/'.$product->id) }}"><i class="mdi mdi-heart"></i></a>
												</div>
											</div>
											<div class="product-dsc">
												<p><a href="{{ url('product/'.$product->id) }}">{{ $product->product_name }}</a></p>
												<!-- <div class="ratting">
													<i class="mdi mdi-star"></i>
													<i class="mdi mdi-star"></i>
													<i class="mdi mdi-star"></i>
													<i class="mdi mdi-star-half"></i>
													<i class="mdi mdi-star-outline"></i>
												</div> -->
												<span>{{ $product->price }} so'm</span>
											</div>
										</div>
									</div>
									<!-- single product end -->
								    @endforeach
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="pagnation-ul">
										<ul class="clearfix">
											<li>{{ $productsAll->links() }}</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- shop content section end -->

@endsection