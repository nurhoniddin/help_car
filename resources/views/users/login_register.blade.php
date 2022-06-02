@extends('layouts.frontLayout.front_design')
@section('content')

        <!-- pages-title-start -->
		<div class="pages-title section-padding">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="pages-title-text text-center">
							<h2>Kirish</h2>
							<ul class="text-left">
								<!-- <li><a href="index.html">Home </a></li>
								<li><span> // </span>Register</li> -->
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- pages-title-end -->
		<!-- login content section start -->
		<section class="pages login-page section-padding">
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
						<div class="main-input padding60">
							<div class="log-title">
								<h3><strong>Kirish</strong></h3>
							</div>
							<div class="login-text">
								<div class="custom-input">
									<!-- <p>If you have an account with us, Please log in!</p> -->
									<form id="loginForm" name="loginForm" action="{{ url('/user-login') }}" method="POST">
							        {{ csrf_field() }}
										<input type="text" name="email" placeholder="Email" required="" />
										<input type="password" name="password" placeholder="Parol" required="" />
										<!-- <a class="forget" href="#">Forget your password?</a> -->
										<div class="submit-text">
											<button type="submit" > ok</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="main-input padding60 new-customer">
							<div class="log-title">
								<h3><strong>Ro'yxatdan o'tish</strong></h3>
							</div>
							<div class="custom-input">
                                <form id="registerForm" name="registerForm" action="{{ url('/user-register') }}" method="POST">
                                {{ csrf_field() }}
									<input type="text" name="name" placeholder="Ismingiz.." require="" />
									<input type="text" name="email" placeholder="Email.." require="" />
									<input type="password" name="password" placeholder="Parol.." require="" />
									<!-- <label class="first-child">
										<input type="radio" name="rememberme" value="forever">
										Sign up for our newsletter!
									</label> -->
									<div class="submit-text coupon">
										<button type="submit" > ok</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- login content section end -->

@endsection