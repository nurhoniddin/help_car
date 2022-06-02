@extends('layouts.frontLayout.front_design')
@section('content')

        <!-- pages-title-start -->
		<div class="pages-title section-padding">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="pages-title-text text-center">
							<h2>Order review</h2>
							<ul class="text-left">
								<li><a href="index.html">Home </a></li>
								<li><span> // </span>Order review</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- pages-title-end -->
		<!-- Checkout content section start -->
		<section class="pages checkout section-padding">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="main-input single-cart-form padding60">
							<div class="log-title">
								<h3><strong>account details</strong></h3>
							</div>
							<div class="custom-input">
									<input type="text" value="{{ $userDetails->name }}" placeholder="Your name" readonly/>
									<input type="text" value="{{ $userDetails->email }}" placeholder="Phone here" readonly/>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="main-input single-cart-form padding60">
							<div class="log-title">
								<h3><strong>ship to address</strong></h3>
							</div>
							<div class="custom-input">
									<input type="text" placeholder="Phone here" value="{{ $shippingDetails->mobile }}" readonly="" />
									<input type="text" placeholder="City" value="{{ $shippingDetails->city }}" readonly="" />
                                    <input type="text" placeholder="Address" value="{{ $shippingDetails->address }}"  readonly="" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Checkout content section end -->
		<!-- cart content section start -->
		<section class="pages cart-page section-padding">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="table-responsive padding60">
							<table class="wishlist-table text-center">
								<thead>
									<tr>
										<th>Product</th>
										<th>Price</th>
										<th>quantity</th>
										<th>Total Price</th>
										<th>Remove</th>
									</tr>
								</thead>
								<tbody>
                                <?php $total_amount = 0; ?>
                                @foreach($userCart as $cart)
									<tr>
										<td class="td-img text-left">
											<a href="#"><img src="{{ asset('images/backend_images/products/small/'.$cart->image) }}" alt="Add Product" /></a>
											<div class="items-dsc">
												<h5><a href="#">{{ $cart->product_name }}</a></h5>
											</div>
										</td>
										<td>{{ $cart->price }} so'm</td>
										<td>
											<form action="#" method="POST">
												<div class="plus-minus">
													<!-- <a class="dec qtybutton" href="{{ url('/cart/update-quantity/'.$cart->id.'/-1') }}">-</a> -->
													<input type="text" value="{{ $cart->quantity }}" autocomplete="off" class="plus-minus-box" readonly="">
													<!-- <a class="inc qtybutton" href="{{ url('/cart/update-quantity/'.$cart->id.'/1') }}">+</a> -->
												</div>
											</form>
										</td>
										<td>
											<strong>{{ $cart->price*$cart->quantity }} so'm</strong>
										</td>
										<td> <!-- <a href="{{ url('/cart/delete-product/'.$cart->id) }}"> <i class="mdi mdi-close" title="Remove this product"></i></a> --></td>
                                    </tr>
                                <?php $total_amount = $total_amount + ($cart->price*$cart->quantity); ?>
                                @endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="row margin-top">
					<div class="col-sm-6">
				       <div class="single-cart-form padding60">
							<div class="log-title">
								<h3><strong>payment details</strong></h3>
							</div>
							<div class="cart-form-text pay-details table-responsive">
								<table>
                                @if(!empty(Session::get('CouponAmount')))
									<tbody>
										<tr>
											<th>Sub Total</th>
											<td><?php echo $total_amount; ?> so'm</td>
										</tr>
										<tr>
											<th>Coupon Discount</th>
											<td><?php echo Session::get('CouponAmount'); ?> so'm</td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<th class="tfoot-padd">Grand total</th>
											<td class="tfoot-padd"><?php echo $grand_total = $total_amount - Session::get('CouponAmount'); ?> so'm</td>
										</tr>
                                    </tfoot>
                                    @else
                                    <tbody>
										<tr>
											<th>Sub Total</th>
											<td><?php echo $total_amount; ?> so'm</td>
										</tr>
										<tr>
											<th>Coupon Discount</th>
											<td><?php echo Session::get('CouponAmount'); ?>0 so'm</td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<th class="tfoot-padd">Grand total</th>
											<td class="tfoot-padd"><?php echo $grand_total = $total_amount; ?> so'm</td>
										</tr>
                                    </tfoot>
                                    @endif
                                </table>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="single-cart-form padding60">
							<div class="log-title">
								<h3><strong>PAYMENT METHOD</strong></h3>
							</div>
							<form name="paymentForm" id="paymentForm" action="{{ url('/place-order') }}" method="post">
							{{ csrf_field() }}
							<input type="hidden" name="grand_total" value="{{ $grand_total }}">
							<div class="cart-form-text pay-details table-responsive">
								<table>
                                    <tbody>
										<tr>
											<th>Payme</th>
											<td><input type="radio" name="payment_method" value="Payme" required=""></td>
										</tr>
									</tbody>
                                </table>
                                <div class="submit-text coupon">
                                	    <button type="submit">Place order</button>
								</div>
							</div>
						    </form>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- cart content section end -->

@endsection