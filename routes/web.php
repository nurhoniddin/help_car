<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get ('/', function () {
//    return view('welcome');});


//Route::get('/admin','AdminController@login');
Route::match(['get','post'],'/admin','AdminController@login');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Index Page
Route::get('/','IndexController@index');

// Category/Listing Page
Route::get('/products/{url}','ProductsController@products');

// Product Detail Page
Route::get('/product/{id}','ProductsController@product');

// Get Product Attribute Price
Route::any('/get-product-price','ProductsController@getProductPrice');

// Add to Cart Route
Route::match(['get','post'],'/add-cart','ProductsController@addtocart');

// Cart Page
Route::match(['get','post'],'/cart','ProductsController@cart');

// Delete Product from Cart Page
Route::get('/cart/delete-product/{id}','ProductsController@deleteCartProduct');

// Update Product Quantity in Cart
Route::get('/cart/update-quantity/{id}/{quantity}','ProductsController@updateCartQuantity');

// Apply Coupon 
Route::post('/cart/apply-coupon','ProductsController@applyCoupon');

// Users Login/Register Page
Route::get('/login-register','UsersController@userLoginRegister');

Route::match(['get','post'],'forgot-password','UsersController@forgotPassword');

// Users Register Form Submit
Route::post('/user-register','UsersController@register');

// Confirm Account
Route::get('confirm/{code}','UsersController@confirmAccount');

// Users Login Form Submit
Route::post('/user-login','UsersController@login');

// Users Logout
Route::get('/user-logout','UsersController@logout');

// Search Products
Route::post('/search-products','ProductsController@searchProducts');

// All Routes after Login
Route::group(['middleware' => ['frontlogin']],function(){
   // Users Account Page
   Route::match(['get','post'],'/account','UsersController@account');
   // Check User Current Password
   Route::post('/check-user-pwd','UsersController@chkUserPassword');
   // Update User Password
   Route::post('/update-user-pwd','UsersController@updatePassword');
   // Checkout Page
   Route::match(['get','post'],'/checkout','ProductsController@checkout');
   // Order Review Page
   Route::match(['get','post'],'/order-review','ProductsController@orderReview');
   // Place Order
   Route::match(['get','post'],'/place-order','ProductsController@placeOrder');
   // Thanks Page
   Route::get('/thanks','ProductsController@thanks');
   // Paypal page
   Route::get('/paypal','ProductsController@paypal');
   // Payme page
   Route::get('/payme','ProductsController@payme');
   // Users Orders Page
   Route::get('/orders','ProductsController@userOrders');
   // User Ordered Products Page
   Route::get('/orders/{id}','ProductsController@userOrderDetails');
   // Paypal Thanks Page
   Route::get('/paypal/thanks','ProductsController@thanksPaypal');
   // Paypal Cancel Page
   Route::get('/paypal/cancel','ProductsController@cancelPaypal');
   // Wish List Page
   Route::match(['get','post'],'wish-list','ProductsController@wishList');
   // Delete Product from Wish List
   Route::get('/wish-list/delete-product/{id}','ProductsController@deleteWishListProduct');
});

// Check if User already exists
Route::match(['GET','POST'],'/check-email','UsersController@checkEmail');

Route::group(['middleware' => ['adminlogin']],function(){
   Route::get('/admin/dashboard','AdminController@dashboard');
   Route::get('/admin/settings','AdminController@settings');
   Route::get('/admin/check-pwd','AdminController@chkPassword');
   Route::match(['get','post'],'/admin/update-pwd','AdminController@updatePassword');

   // categories Routes (Admin)
   Route::match(['get','post'],'/admin/add-category','CategoryController@addCategory');
   Route::match(['get','post'],'/admin/edit-category/{id}','CategoryController@editCategory');
   Route::match(['get','post'],'/admin/delete-category/{id}','CategoryController@deleteCategory');
   Route::get('/admin/view-categories','CategoryController@viewCategories');

   // Products Routes
   Route::match(['get','post'],'/admin/add-product','ProductsController@addProduct');
   Route::match(['get','post'],'/admin/edit-product/{id}','ProductsController@editProduct');
   Route::get('/admin/view-products','ProductsController@viewProducts');
   Route::get('/admin/delete-product/{id}','ProductsController@deleteProduct');
   Route::get('/admin/delete-product-image/{id}','ProductsController@deleteProductImage');
   Route::get('/admin/delete-alt-image/{id}','ProductsController@deleteAltImage');

   // Products Attributes Routes
   Route::match(['get','post'],'admin/add-attributes/{id}','ProductsController@addAttributes');
   Route::match(['get','post'],'admin/edit-attributes/{id}','ProductsController@editAttributes');
   Route::match(['get','post'],'admin/add-images/{id}','ProductsController@addImages');
   Route::get('/admin/delete-attribute/{id}','ProductsController@deleteAttribute');

   // Coupon Routes
   Route::match(['get','post'],'/admin/add-coupon','CouponsController@addCoupon');
   Route::match(['get','post'],'admin/edit-coupon/{id}','CouponsController@editCoupon');
   Route::get('/admin/view-coupons','CouponsController@viewCoupons');
   Route::get('/admin/delete-coupon/{id}','CouponsController@deleteCoupon');

   // Admin Banners Routes
   Route::match(['get','post'],'/admin/add-banner','BannersController@addBanner');
   Route::match(['get','post'],'/admin/edit-banner/{id}','BannersController@editBanner');
   Route::get('admin/view-banners','BannersController@viewBanners');
   Route::get('/admin/delete-banner/{id}','BannersController@deleteBanner');

   // Admin Orders Routes
   Route::get('/admin/view-orders','ProductsController@viewOrders');

   // Admin Orders Details Page
   Route::get('/admin/view-order/{id}','ProductsController@viewOrderDetails');

   // Order Invoice
   Route::get('/admin/view-order-invoice/{id}','ProductsController@viewOrderInvoice');

   // PDF Invoice
   Route::get('/admin/view-pdf-invoice/{id}','ProductsController@viewPDFInvoice');

   // Update Order Status
   Route::post('/admin/update-order-status','ProductsController@updateOrderStatus');
});

Route::get('/logout', 'AdminController@logout');
