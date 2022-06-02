<?php 
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
$mainCategories = Controller::mainCategories();
$cartCount = Product::cartCount();
 // Get all Categories and Sub Categories
 $categories = Category::with('categories')->where(['parent_id'=>0])->get();
?>


        <!-- header section start -->
		<header class="header-one header-two">
			<div class="header-top-two">
				<div class="container text-center">
					<div class="row">
						<div class="col-sm-12">
							<div class="middel-top">
								<div class="left floatleft">
									<!-- <p><i class="mdi mdi-clock"></i> Mon-Fri : 09:00-19:00</p> -->
								</div>
							</div>
							<div class="middel-top clearfix">
								<ul class="clearfix right floatright">
									<li>
										<a href="#"><i class="mdi mdi-account"></i></a>
										<ul>
                                            @if(empty(Auth::check()))
											<li><a href="{{ url('/login-register') }}">Kirish</a></li>
                                            <li><a href="{{ url('/login-register') }}">Ro'yxatdan o'tish</a></li>
                                            @else
                                            <li><a href="{{ url('/account') }}"> Mening profilim</a></li>
								            <li><a href="{{ url('/user-logout') }}"> Chiqish</a></li>
                                            @endif
										</ul>
									</li>
									<li>
										<a href="#"><i class="mdi mdi-settings"></i></a>
										<ul>
											<li><a href="{{ url('/cart') }}">Savat</a></li>
                                            <li><a href="{{ url('/wish-list') }}">Tanlangan</a></li>
								            <li><a href="{{ url('/orders') }}">Zakazlar</a></li>
										</ul>
									</li>
								</ul>
								<div class="right floatright">
                                    <form action="{{ url('/search-products') }}" method="post">
                                    {{ csrf_field() }}
										<button type="submit"><i class="mdi mdi-magnify"></i></button>
                                        <input type="text" placeholder="Search within these results..." name="product" />
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container text-center">
				<div class="row">
					<div class="col-sm-2">
						<div class="logo">
							<a href="{{ asset('/') }}"><img src="{{ asset('images/logo2.png') }}" alt="Sellshop" /></a>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="header-middel">
							<div class="mainmenu">
								<nav>
									<ul>
                                        </li>
                                        @foreach($categories as $cat)
                                        <li><a href="{{ asset('/products/'.$cat->url) }}">{{ $cat->name }}</a>
											<ul class="dropdown">
                                                @foreach($cat->categories as $subcat)
                                                <li><a href="{{ asset('/products/'.$subcat->url) }}">{{ $subcat->name }}</a></li>
                                                @endforeach	
                                            </ul>
                                        </li>
                                        @endforeach
									</ul>
								</nav>
							</div>
							<!-- mobile menu start -->
							<div class="mobile-menu-area">
								<div class="mobile-menu">
									<nav id="dropdown">
										<ul>
                                            @foreach($categories as $cat)
                                            <li><a href="{{ asset('/products/'.$cat->url) }}">{{ $cat->name }}</a>
												<ul class="dropdown">
                                                    @foreach($cat->categories as $subcat)
													<li><a href="{{ asset('/products/'.$subcat->url) }}">{{ $subcat->name }}</a></li>
                                                    @endforeach	
                                                </ul>
                                            </li>
                                            @endforeach  
										</ul>
									</nav>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="cart-itmes">
							<a class="cart-itme-a" href="{{ url('/cart') }}">
								<i class="mdi mdi-cart"></i>
								 Savat :  <strong>{{ $cartCount }}</strong>
							</a>
						</div>
					</div>
				</div>
			</div>
		</header>
        <!-- header section end -->
      
