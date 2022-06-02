@extends('layouts.frontLayout.front_design')
@section('content')
<?php use App\Product; ?>
        <!-- pages-title-start -->
		<div class="pages-title section-padding">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="pages-title-text text-center">
							<h2>Saralanganlar</h2>
							<ul class="text-left">
								<!-- <li><a href="index.html">Home </a></li>
								<li><span> // </span>Cart</li> -->
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- pages-title-end -->
		<!-- cart content section start -->
		<section class="pages cart-page section-padding">
			<div class="container">
				<div class="row">
                @if(Session::has('flash_message_error')) 
                <div class="alert alert-danger alert-block">
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
					<div class="col-xs-12">
						<div class="table-responsive padding60">
							<table class="wishlist-table text-center">
								<thead>
									<tr>
										<th>Mahsulot</th>
										<th>Narxi</th>
										<th>Miqdori</th>
										<th>Jami Narxi</th>
										<th>O'chirish</th>
									</tr>
								</thead>
								<tbody>
                                <?php $total_amount = 0; ?>
                                @foreach($userWishList as $wishlist)
									<tr>
										<td class="td-img text-left">
											<a href="#"><img src="{{ asset('images/backend_images/products/small/'.$wishlist->image) }}" alt="Add Product" /></a>
											<div class="items-dsc">
												<h5><a href="#">{{ $wishlist->product_name }}</a></h5>
											</div>
										</td>
										<td>{{ $wishlist->price }} so'm</td>
										<td>
											<form action="#" method="POST">
												<div class="plus-minus">
													<!-- <a class="dec qtybutton" href="{{ url('/wishlist/update-quantity/'.$wishlist->id.'/-1') }}">-</a> -->
													<input type="text" value="{{ $wishlist->quantity }}" autocomplete="off" name="quantity" class="plus-minus-box">
													<!-- <a class="inc qtybutton" href="{{ url('/wishlist/update-quantity/'.$wishlist->id.'/1') }}">+</a> -->
												</div>
											</form>
										</td>
										<td>
											<strong>{{ $wishlist->price*$wishlist->quantity }} so'm</strong>
										</td>
										<td> <a href="{{ url('/wish-list/delete-product/'.$wishlist->id) }}"> <i class="mdi mdi-close" title="Remove this product"></i></a></td>
                                    </tr>
                                <?php $total_amount = $total_amount + ($wishlist->price*$wishlist->quantity); ?>
                                @endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- cart content section end -->

@endsection