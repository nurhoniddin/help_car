@extends('layouts.frontLayout.front_design')
@section('content')

        <!-- pages-title-start -->
		<div class="pages-title section-padding">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="pages-title-text text-center">
							<h2>Savat</h2>
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
													<a class="dec qtybutton" href="{{ url('/cart/update-quantity/'.$cart->id.'/-1') }}">-</a>
													<input type="text" value="{{ $cart->quantity }}" autocomplete="off" name="quantity" class="plus-minus-box">
													<a class="inc qtybutton" href="{{ url('/cart/update-quantity/'.$cart->id.'/1') }}">+</a>
												</div>
											</form>
										</td>
										<td>
											<strong>{{ $cart->price*$cart->quantity }} so'm</strong>
										</td>
										<td> <a href="{{ url('/cart/delete-product/'.$cart->id) }}"> <i class="mdi mdi-close" title="Remove this product"></i></a></td>
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
								<h3><strong>kupon uchun chegirma</strong></h3>
							</div>
							<div class="cart-form-text custom-input">
								<p>Agar sizda bo'lsa, kupon kodingizni kiriting!</p>
								<form action="{{ url('cart/apply-coupon') }}" method="post">
									{{ csrf_field() }}
									<input type="text" name="coupon_code" placeholder="kupon kodingizni kiriting..." />
									<div class="submit-text coupon">
										<button type="submit">ok</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="single-cart-form padding60">
							<div class="log-title">
								<h3><strong>to'lov ma'lumotlari</strong></h3>
							</div>
							<div class="cart-form-text pay-details table-responsive">
								<table>
                                @if(!empty(Session::get('CouponAmount')))
									<tbody>
										<tr>
											<th>Narxi</th>
											<td><?php echo $total_amount; ?> so'm</td>
										</tr>
										<tr>
											<th>Chegirma</th>
											<td><?php echo Session::get('CouponAmount'); ?> so'm</td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<th class="tfoot-padd">Jami narxi</th>
											<td class="tfoot-padd"><?php echo $total_amount - Session::get('CouponAmount'); ?> so'm</td>
										</tr>
                                    </tfoot>
                                    @else
                                    <tbody>
										<tr>
											<th>Narxi</th>
											<td><?php echo $total_amount; ?> so'm</td>
										</tr>
										<tr>
											<th>Chegirma</th>
											<td><?php echo Session::get('CouponAmount'); ?>0 so'm</td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<th class="tfoot-padd">Jami narxi</th>
											<td class="tfoot-padd"><?php echo $total_amount; ?> so'm</td>
										</tr>
                                    </tfoot>
                                    @endif
                                </table>
                                <div class="submit-text coupon">
										<a href="{{ url('/checkout') }}">Buyurtmani rasmiylashtirish </a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- cart content section end -->

@endsection