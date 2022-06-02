@extends('layouts.frontLayout.front_design')
@section('content')

        <!-- pages-title-start -->
		<div class="pages-title section-padding">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="pages-title-text text-center">
							<h2>Buyurtmani rasmiylashtirish</h2>
							<ul class="text-left">
								<!-- <li><a href="index.html">Home </a></li>
								<li><span> // </span>Chcekout</li> -->
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
					<div class="col-sm-6">
						<div class="main-input single-cart-form padding60">
							<div class="log-title">
								<h3><strong>Mening profilim</strong></h3>
							</div>
							<div class="custom-input">
									<input type="text" value="{{ $userDetails->name }}" placeholder="Your name" readonly/>
									<input type="text" value="{{ $userDetails->email }}" placeholder="Phone here" readonly/>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="main-input single-cart-form padding60">
						 <form action="{{ url('/checkout') }}" method="post">
				            {{ csrf_field() }}
							<div class="log-title">
								<h3><strong>Yetkazib berish uchun manzil</strong></h3>
							</div>
							<div class="custom-input">
									<input type="text" name="mobile" placeholder="Telefon" @if(!empty($shippingDetails->mobile)) value="{{ $shippingDetails->mobile }}" @endif />
									<input type="text" name="city" placeholder="Shahar" @if(!empty($shippingDetails->city)) value="{{ $shippingDetails->city }}" @endif />
                                    <input type="text" name="address" placeholder="To'liq manzil" @if(!empty($shippingDetails->address)) value="{{ $shippingDetails->address }}" @endif />
							</div>
							<div class="log-title">
							<br>
							<br>
								<h3><strong>To‘lov turi</strong></h3>
							</div>
							<div class="cart-form-text pay-details table-responsive">
								<table>
                                    <tbody>
										<tr>
											<th><img src="{{ asset('images/payme_01.png') }}" alt="payme" style="width: 150px;"></th>
											<td><input type="radio" name="payment_method" value="Payme" required=""></td>
										</tr>
									</tbody>
                                </table>
                                <div class="submit-text coupon">
                                	    <!-- <button type="submit">Place order</button> -->
										<a href="#">ok</a>
								</div>
							</div>
						  </form>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Checkout content section end -->

@endsection