<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Auth;
use Session;
use Image;
use App\Category;
use App\Product;
use App\ProductsAttribute;
use App\ProductsImage;
use App\Coupon;
use App\User;
use App\Country;
use App\DeliveryAddress;
use App\Order;
use App\OrdersProduct;
use DB;
use Carbon\Carbon;
use Dompdf\Dompdf;

class ProductsController extends Controller
{
    public function addProduct(Request $request){

    	if ($request->isMethod('post')) {
    		$data = $request->all();
    		if (empty($data['category_id'])) {
    			return redirect()->back()->with('flash_message_error','Under Category is mmissing!');
    		}
    		$product = new Product;
    		$product->category_id = $data['category_id'];
    		$product->product_name = $data['product_name'];
    		if (!empty($data['description'])) {
    		$product->description = $data['description'];
    		}else{
    			$product->description = '';
    		}

            $product->price = $data['price'];
            
    		$product->price_two = $data['price_two'];
    		
            // Upload Image
             if ($request->hasFile('image')) {
             	$image_tmp = Input::file('image');
             	if ($image_tmp->isValid()) {
             		$extension = $image_tmp->getClientOriginalExtension();
             		$filename = rand(111,99999).'.'.$extension;
             		$large_image_path = 'images/backend_images/products/large/'.$filename;
             		$medium_image_path = 'images/backend_images/products/medium/'.$filename;
             		$small_image_path = 'images/backend_images/products/small/'.$filename;
             		// resize images
             		Image::make($image_tmp)->save($large_image_path);
             		Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
             		Image::make($image_tmp)->resize(300,300)->save($small_image_path);

             		// store image name in products table
             		$product->image = $filename;
             	}
             }

             if (empty($data['status'])) {
                $status = 0;
            }else{
               $status = 1;
            }

            if (empty($data['featured'])) {
                $featured = 0;
            }else{
               $featured = 1;
            }

            if (empty($data['new'])) {
                $new = 0;
            }else{
               $new = 1;
            }

            if (empty($data['popular'])) {
                $popular = 0;
            }else{
               $popular = 1;
            }

             if (empty($data['best'])) {
                 $best = 0;
             }else{
                $best = 1;
             }
            
            $product->status = $status;
            $product->featured = $featured;
            $product->new = $new;
            $product->popular = $popular;
            $product->best = $best;

    		$product->save();
    		 return redirect()->back()->with('flash_message_success','Product has been added successfully!');
            //return redirect('/admin/view-products')->with('flash_message_success','Product has been added successfully!');
    	}
        
        //Categories drop down start
    	$categories =Category::where(['parent_id'=>0])->get();
    	$categories_dropdown = "<option value='' selected disabled>Select</option>";
    	foreach($categories as $cat){
    		$categories_dropdown .= "<option value='".$cat->id."'>".$cat->name."</option>";
    		$sub_categories = Category::where(['parent_id'=>$cat->id])->get();
    		foreach($sub_categories as $sub_cat){
    			$categories_dropdown.= "<option value='".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->name."</option>";
    		}
    	}
        //Categories drop down ends 

    	return view('admin.products.add_product')->with(compact('categories_dropdown'));
    }

    public function editProduct(Request $request, $id=null){

        if ($request->isMethod('post')) {
            $data = $request->all();

            
             // Upload Image
             if ($request->hasFile('image')) {
                $image_tmp = Input::file('image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path = 'images/backend_images/products/small/'.$filename;
                    // resize images
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);

          
                }
             }else{
                $filename = $data['current_image'];
             }

             if (empty($data['description'])) {
                 $data['description'] = '';
             }

             if (empty($data['status'])) {
                $status = 0;
            }else{
               $status = 1;
            }

            if (empty($data['featured'])) {
                $featured = 0;
            }else{
               $featured = 1;
            }

            if (empty($data['new'])) {
                $new = 0;
            }else{
               $new = 1;
            }

            if (empty($data['popular'])) {
                $popular = 0;
            }else{
               $popular = 1;
            }

             if (empty($data['best'])) {
                 $best = 0;
             }else{
                $best = 1;
             }
            
            Product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],'product_name'=>$data['product_name'],'description'=>$data['description'],'price'=>$data['price'],'price_two'=>$data['price_two'],'image'=>$filename,'status'=>$status,'featured'=>$featured,'new'=>$new,'popular'=>$popular,'best'=>$best]);
            return redirect()->back()->with('flash_message_success','Product has been updated successfully!');
        }

        //Get Product Details
        $productDetails = Product::where(['id'=>$id])->first();

        //Categories drop down start
        $categories =Category::where(['parent_id'=>0])->get();
        $categories_dropdown = "<option value='' selected disabled>Select</option>";
        foreach($categories as $cat){
            if ($cat->id==$productDetails->category_id) {
                $selected = "selected";
            }else{
                $selected = "";
            }
            $categories_dropdown .= "<option value='".$cat->id."' ".$selected.">".$cat->name."</option>";
            $sub_categories = Category::where(['parent_id'=>$cat->id])->get();
            foreach($sub_categories as $sub_cat){
            if ($sub_cat->id==$productDetails->category_id) {
                $selected = "selected";
            }else{
                $selected = "";
            }
                $categories_dropdown.= "<option value='".$sub_cat->id."' ".$selected.">&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }
        //Categories drop down ends 

        return view('admin.products.edit_product')->with(compact('productDetails','categories_dropdown'));
    }

    public function viewProducts(Request $request){
        $products = Product::orderby('id','DESC')->get();
        $products = json_decode(json_encode($products));
        foreach($products as $key => $val){
            $category_name = Category::where(['id'=>$val->category_id])->first();
            $products[$key]->category_name = $category_name->name;
        }
        return view('admin.products.view_products')->with(compact('products'));
    }

    public function deleteProduct($id=null){
        Product::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Product has been deleted successfully!');
    }

    public function deleteProductImage($id = null){

        // Get Product Image Name
        $productImage = Product::where(['id'=>$id])->first();
  
        // Get Product Image Paths
        $large_image_path = 'images/backend_images/products/large/';
        $medium_image_path = 'images/backend_images/products/medium/';
        $small_image_path = 'images/backend_images/products/small/';

        // Delete Large image if not exists in Folder
        if (file_exists($large_image_path.$productImage->image)) {
            unlink($large_image_path.$productImage->image);
        }

        // Delete medium image if not exists in Folder
        if (file_exists($medium_image_path.$productImage->image)) {
            unlink($medium_image_path.$productImage->image);
        }

        // Delete small image if not exists in Folder
        if (file_exists($small_image_path.$productImage->image)) {
            unlink($small_image_path.$productImage->image);
        }
        
        // Delete Image from Products table
        Product::where(['id'=>$id])->update(['image'=>'']);

        return redirect()->back()->with('flash_message_success','Product Image has been deleted successfully!');
    }

    public function deleteAltImage($id = null){

        // Get Product Image Name
        $productImage = ProductsImage::where(['id'=>$id])->first();
  
        // Get Product Image Paths
        $large_image_path = 'images/backend_images/products/large/';
        $medium_image_path = 'images/backend_images/products/medium/';
        $small_image_path = 'images/backend_images/products/small/';

        // Delete Large image if not exists in Folder
        if (file_exists($large_image_path.$productImage->image)) {
            unlink($large_image_path.$productImage->image);
        }

        // Delete medium image if not exists in Folder
        if (file_exists($medium_image_path.$productImage->image)) {
            unlink($medium_image_path.$productImage->image);
        }

        // Delete small image if not exists in Folder
        if (file_exists($small_image_path.$productImage->image)) {
            unlink($small_image_path.$productImage->image);
        }
        
        // Delete Image from Products table
        ProductsImage::where(['id'=>$id])->delete();

        return redirect()->back()->with('flash_message_success','Product Alternate Image(s) has been deleted successfully!');
    }

    public function addAttributes(Request $request,$id=null){
        $productDetails = Product::with('attributes')->where(['id'=>$id])->first();
        // $productDetails = json_decode(json_encode($productDetails));
        // echo "<pre>"; print_r($productDetails); die;
        if($request->isMethod('post')){
            $data = $request->all();

            foreach($data['name'] as $key => $val){
                if (!empty($val)) {

                    // Prevent dublicate SKU Check
                    // $attrCountSKU = ProductsAttribute::where('name',$val)->count();
                    // if ($attrCountSKU>0) {
                    //     return redirect('admin/add-attributes/'.$id)->with('flash_message_error','Name already exists! Please add another Name.');
                    // }


                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->name = $data['name'][$key];
                    $attribute->description = $data['description'][$key];
                    $attribute->save();
                }
            }
             return redirect('admin/add-attributes/'.$id)->with('flash_message_success','Product Attributes has been added successfully!');
        }
        return view('admin.products.add_attributes')->with(compact('productDetails'));
    }

    public function editAttributes(Request $request,$id=null){
        if ($request->isMethod('post')) {
            $data = $request->all();

            foreach ($data['idAttr'] as $key => $attr) {
                ProductsAttribute::where(['id'=>$data['idAttr'][$key]])->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);
            }
        return redirect()->back()->with('flash_message_success','Products Attributes has been update successfully!');
        }
    }

    public function addImages(Request $request,$id=null){
        $productDetails = Product::with('attributes')->where(['id'=>$id])->first();

        if($request->isMethod('post')){
            $data = $request->all();
            if ($request->hasFile('image')) {
                   $files = $request->file('image');
                   foreach ($files as $file) {
                    // Upload Images after resize
                    $image = new ProductsImage;
                    $extension = $file->getClientOriginalExtension();
                    $fileName = rand(111,99999).'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large/'.$fileName;
                    $medium_image_path = 'images/backend_images/products/medium/'.$fileName;
                    $small_image_path = 'images/backend_images/products/small/'.$fileName;
                    Image::make($file)->save($large_image_path);
                    Image::make($file)->resize(600,600)->save($medium_image_path);
                    Image::make($file)->resize(300,300)->save($small_image_path);
                    $image->image = $fileName;
                    $image->product_id = $data['product_id'];
                    $image->save();
               }

            }
            return redirect('admin/add-images/'.$id)->with('flash_message_success','Product Image has been added successfully');
        }

        $productsImg = ProductsImage::where(['product_id'=>$id])->get();
        $productsImg = json_decode(json_encode($productsImg));

        $productsImages = "";
        foreach($productsImg as $img){
            $productsImages .= "<tr>
                <td>".$img->id."</td>
                <td>".$img->product_id."</td>
                <td><img style='width:150px' src='/images/backend_images/products/small/$img->image'></td>
                <td>
           <a rel='$img->id' rel1='delete-alt-image' href='javascript:' class='btn btn-danger btn-mmini deleteRecord' title='Delete Product Image'>Delete</a>
                 </td>
              </tr>";
        }

        return view('admin.products.add_images')->with(compact('productDetails','productsImages'));
    }

    public function deleteAttribute($id = null){
        ProductsAttribute::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Attribute has been deleted successfully!');
    }

    public function products($url = null){

        // Show 404 page if Category URL does not exist
        $countCategory = Category::where(['url'=>$url,'status'=>1])->count();
        if ($countCategory==0) {
             abort(404);
         } 
         
        // Get all Categories and Sub Categories
        $categories = Category::with('categories')->where(['parent_id'=>0])->get();

        $categoryDetails = Category::where(['url' => $url])->first();

        if ($categoryDetails->parent_id==0) {
            // If url is main Category url
            $subCategories = Category::where(['parent_id'=>$categoryDetails->id])->get();
            foreach($subCategories as $subcat){
                $cat_ids[] = $subcat->id;
            }
            // print_r($cat_ids); die; 
            $productsAll = Product::whereIn('category_id',$cat_ids)->where('status',1)->paginate(16);
            //$productsAll = json_decode(json_encode($productsAll)); 
            // echo "<pre>"; print_r($productsAll); die; 
        }else{
            // If url is sub category url
            $productsAll = Product::where(['category_id' => $categoryDetails->id])->where('status',1)->paginate(16);
        }        

        //$productsAll = Product::where(['category_id' => $categoryDetails->id])->get();
        return view('products.listing')->with(compact('categories','categoryDetails','productsAll'));
    }

    public function searchProducts(Request $request){
        if ($request->isMethod('post')) {
            $data = $request->all();

            $categories = Category::with('categories')->where(['parent_id' => 0])->get();

            $search_product = $data['product']; 

            $productsAll = Product::where('product_name','like','%'.$search_product.'%')->orwhere('product_code',$search_product)->where('status',1)->paginate(9);

            return view('products.listing')->with(compact('categories','productsAll','search_product'));
        }
    }

    public function product($id = null){

        // Show 404 page if product is disabled
        $productsCount = Product::where(['id'=>$id,'status'=>1])->count();
        if ($productsCount == 0) {
            abort(404);
        }

        // Get Product Details 
        $productDetails = Product::with('attributes')->where('id',$id)->first();
        $productDetails = json_decode(json_encode($productDetails));

        // $relatedProducts = Product::where('id','!=',$id)->where(['category_id'=>$productDetails->category_id])->paginate(8);
       // $relatedProducts = json_decode(json_encode($relatedProducts));
       $relatedProducts = Product::orderBy('id','DESC')->paginate(8);

        // Get all Categories and Sub Categories
        $categories = Category::with('categories')->where(['parent_id'=>0])->get();

        // Get Product Alternate Images
        $productAltImages = ProductsImage::where('product_id',$id)->get();

        // $total_stock = ProductsAttribute::where('product_id',$id)->sum('stock');

        return view('products.detail')->with(compact('productDetails','categories','productAltImages','relatedProducts'));
    }

    public function getProductPrice(Request $request){
        $data = $request->all();
        $proArr = explode("-",$data['idSize']);
        $proAttr = ProductsAttribute::where(['product_id' => $proArr[0], 'size' => $proArr[1]])->first();
        echo $proAttr->price;
        echo "#";
        echo $proAttr->stock;
    }

    public function addtocart(Request $request){

        Session::forget('CouponAmount');
        Session::forget('CouponCode');

        $data =$request->all();

        if (!empty($data['wishListButton']) && $data['wishListButton']=="Wish List") {
            
            // Check User is logged in
            if (!Auth::check()) {
                return redirect()->back()->with('flash_message_error','Please login to add product in your Wish List');
            }

            // // Check Size is selected
            // if (empty($data['size'])) {
            //     return redirect()->back()->with('flash_message_error','Please select size to add product in your Wish List');
            // }

            // Get Product Size
            // $sizeIDArr = explode('-',$data['size']);
            // $product_size = $sizeIDArr[1];

            // Get Product Price
            // $proPrice = ProductsAttribute::where(['product_id'=>$data['product_id'],'size'=>$product_size])->first();
            // $product_price = $proPrice->price;

            // Get User Email/Username
            $user_email = Auth::user()->email;

            // Set Quantity as 1
            $quantity = 1;

            // Get Current Date
            $created_at = Carbon::now();

            $wishListCount = DB::table('wish_list')->where(['user_email'=>$user_email,'product_id'=>$data['product_id']])->count();

            if ($wishListCount>0) {
                return redirect()->back()->with('flash_message_error','Please already exists in Wish List!');
            }else{

            // Insert Product in Wish List
            DB::table('wish_list')->insert(['product_id'=>$data['product_id'],'product_name'=>$data['product_name'],'price'=>$data['price'],'quantity'=>$quantity,'user_email'=>$user_email,'created_at'=>$created_at]);
            return redirect()->back()->with('flash_message_success','Product has been added in Wish List');
            }


        }else{
        
        // if product added from Wish List
        if (!empty($data['cartButton']) && $data['cartButton']=="Add to Cart") {
            $data['quantity'] = 1;
        }
            
        // Check Product Stock is available or not
        // $product_size = explode("-",$data['size']);
        // $getProductStock = ProductsAttribute::where(['product_id'=>$data['product_id'],'size'=>$product_size[1]])->first();

        // if ($getProductStock->stock<$data['quantity']) {
        //     return redirect()->back()->with('flash_message_error','Required Quantity is not available!');
        // }

        if (empty(Auth::user()->email)) {
            $data['user_email'] = '';
        }else{
            $data['user_email'] = Auth::user()->email;
        }

        $session_id = Session::get('session_id');
        if (!isset($session_id)) {
             $session_id = str_random(40);
             Session::put('session_id',$session_id);
        }

        // $sizeIDArr = explode('-',$data['size']);
        // $product_size = $sizeIDArr[1];

        if (empty(Auth::check())) {
           $countProducts = DB::table('cart')->where(['product_id'=>$data['product_id'],'session_id'=>$session_id])->count();
           if ($countProducts>0) {
            return redirect()->back()->with('flash_message_error','Product already exists in Cart!');
           }
        }else{
           $countProducts = DB::table('cart')->where(['product_id'=>$data['product_id'],'user_email'=>Auth::user()->email])->count();
           if ($countProducts>0) {
            return redirect()->back()->with('flash_message_error','Product already exists in Cart!');
           }
        }

        // $getSKU = ProductsAttribute::select('sku')->where(['product_id'=>$data['product_id'],'size'=>$product_size])->first();

        DB::table('cart')->insert(['product_id'=>$data['product_id'],'product_name'=>$data['product_name'],'price'=>$data['price'],'quantity'=>$data['quantity'],'user_email'=>$data['user_email'],'session_id'=>$session_id]);

        return redirect('/cart')->with('flash_message_success','Product has been added in Cart!');
        }

        
    }

    public function cart(){
        if (Auth::check()) {
           $user_email = Auth::user()->email;
           $userCart = DB::table('cart')->where(['user_email'=>$user_email])->get();
        }else{
           $session_id = Session::get('session_id');
           $userCart = DB::table('cart')->where(['session_id'=>$session_id])->get();
        }
   
        foreach($userCart as $key => $product){
            $productDetails = Product::where('id',$product->product_id)->first();
            $userCart[$key]->image = $productDetails->image;
        }

        return view('products.cart')->with(compact('userCart'));
        // return response()->json([
        //     'user_cart' => $userCart
        // ]);
    }

    public function wishList(){
        if (Auth::check()) {
            $user_email = Auth::user()->email;
            $userWishList = DB::table('wish_list')->where('user_email',$user_email)->get();
            foreach($userWishList as $key => $product){
                $productDetails = Product::where('id',$product->product_id)->first();
                $userWishList[$key]->image = $productDetails->image;
            }
        }else{
            $userWishList = array();
        }
        
        return view('products.wish_list')->with(compact('userWishList'));
    }

    public function updateCartQuantity($id=null,$quantity=null){
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        $getProductSKU = DB::table('cart')->select('quantity')->where('id',$id)->first();
        // $getProductStock = ProductsAttribute::where('sku',$getProductSKU->product_code)->first();
        $updated_quantity = $getProductSKU->quantity+$quantity;
        if (true) {
            DB::table('cart')->where('id',$id)->increment('quantity',$quantity);
        return redirect('cart')->with('flash_message_success','Product Quantity has been updated in Cart!');
        }else{
            return redirect('cart')->with('flash_message_error','Required Product Quantity is not available!');
        }
        
    }

    public function deleteCartProduct($id = null){
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        DB::table('cart')->where('id',$id)->delete();
        return redirect('cart')->with('flash_message_success','Product has been deleted in Cart!');
    }

    public function applyCoupon(Request $request){

        Session::forget('CouponAmount');
        Session::forget('CouponCode');

        $data = $request->all();
        $couponCount = Coupon::where('coupon_code',$data['coupon_code'])->count();
        if ($couponCount == 0) {
            return redirect()->back()->with('flash_message_error','This coupon does not exits!');
        }else{
            // with perform other like Active/Inactive, Expiry date...
            
            // Get Coupon Details
            $couponDetails = Coupon::where('coupon_code',$data['coupon_code'])->first();

            // if coupon is Inactive
            if ($couponDetails->status==0) {
                return redirect()->back()->with('flash_message_error','This coupon is not active!');
            }

            // If coupon is Expired
            $expiry_date = $couponDetails->expiry_date;
            $current_date = date('Y-m-d');
            if ($expiry_date < $current_date) {
                return redirect()->back()->with('flash_message_error','This coupon is expired!');
            }

            // Coupon is Valid for Discount

            // Get Cart Total Amount
            $session_id = Session::get('session_id');
            $userCart = DB::table('cart')->where(['session_id'=>$session_id])->get();
            $total_amount = 0;
            foreach($userCart as $item){
                $total_amount = $total_amount + ($item->price * $item->quantity);
            }

            // Check if amount type is Fixed or Percentage
            if ($couponDetails->amount_type=="Fixed") {
                $couponAmount = $couponDetails->amount;
            }else{
                $couponAmount = $total_amount * ($couponDetails->amount/100);
            }

            // Add Coupon Code & Amount inn Session
            Session::put('CouponAmount',$couponAmount);
            Session::put('CouponCode',$data['coupon_code']);

            return redirect()->back()->with('flash_message_success','Coupon code successfully applied. You are availing discount!');
        }
    }

    public function checkout(Request $request){
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::find($user_id);
        $countries = Country::get();

        // Check if Shipping Address exists
        $shippingCount = DeliveryAddress::where('user_id',$user_id)->count();
        $shippingDetails = array();
        if ($shippingCount>0) {
            $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
        }

        // Update cart table with user email 
        $session_id = Session::get('session_id');
        DB::table('cart')->where(['session_id'=>$session_id])->update(['user_email'=>$user_email]);

        if ($request->isMethod('post')) {
            $data = $request->all();

            // Return to Checkout page if any of the field is empty
            // if (empty($data['billing_name']) || empty($data['billing_address']) || empty($data['billing_city']) || empty($data['billing_state']) || empty($data['billing_country']) || empty($data['billing_mobile']) || empty($data['shipping_name']) || empty($data['shipping_address']) || empty($data['shipping_city']) || empty($data['shipping_state']) || empty($data['shipping_country']) || empty($data['shipping_mobile'])) {
            //       return redirect()->back()->with('flash_message_error','Please fill all fields to Checkout!');
            // }

            // if (empty($data['billing_pincode'])) {
            //     $data['billing_pincode'] = '';
            // }

            // Update User details
            // User::where('id',$user_id)->update(['name'=>$data['billing_name'],'address'=>$data['billing_address'],'city'=>$data['billing_city'],'state'=>$data['billing_state'],'pincode'=>$data['billing_pincode'],'country'=>$data['billing_country'],'mobile'=>$data['billing_mobile']]);

            if ($shippingCount>0) {

                // if (empty($data['shipping_pincode'])) {
                // $data['shipping_pincode'] = '';
                // }
                // Update Shipping Address
                DeliveryAddress::where('user_id',$user_id)->update(['mobile'=>$data['mobile'],'address'=>$data['address'],'city'=>$data['city']]);
            }else{

                // if (empty($data['shipping_pincode'])) {
                // $data['shipping_pincode'] = '';
                // }

                // Add New Shipping Address
                $shipping = new DeliveryAddress;
                $shipping->user_id = $user_id;
                $shipping->user_email = $user_email;
                $shipping->mobile = $data['mobile'];
                $shipping->address = $data['address'];
                $shipping->city = $data['city'];
                $shipping->save();
            }
            return redirect()->action('ProductsController@orderReview');
        }

        return view('products.checkout')->with(compact('userDetails','countries','shippingDetails'));
    }

    public function orderReview(){
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::where('id',$user_id)->first();
        $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
        $shippingDetails = json_decode(json_encode($shippingDetails));
        $userCart = DB::table('cart')->where(['user_email'=>$user_email])->get();
        foreach($userCart as $key => $product){
            $productDetails = Product::where('id',$product->product_id)->first();
            $userCart[$key]->image = $productDetails->image;
        }
        return view('products.order_review')->with(compact('userDetails','shippingDetails','userCart'));
    }

    public function placeOrder(Request $request){
        if ($request->isMethod('post')) {
            $data = $request->all();
            $user_id = Auth::user()->id;
            $user_email = Auth::user()->email;
            $user_name = Auth::user()->name;

            // Prevent Out of Stock Products from ordering
            // $userCart = DB::table('cart')->where('user_email',$user_email)->get();
            // foreach ($userCart as $cart) {

            //     $getAttributeCount = Product::getAttributeCount($cart->product_id,$cart->size);
            //     if ($getAttributeCount==0) {
            //         Product::deleteCartProduct($cart->product_id,$user_email);
            //         return redirect('/cart')->with('flash_message_error','One of the product is not available. Try again.');
            //     }

            //     $product_stock = Product::getProductStock($cart->product_id,$cart->size);
            //     if ($product_stock==0) {
            //         Product::deleteCartProduct($cart->product_id,$user_email);
            //         return redirect('/cart')->with('flash_message_error','Sold Out product removed from Cart. Try again!');
            //     }

            //     if ($cart->quantity>$product_stock) {
            //         return redirect('/cart')->with('flash_message_error','Reduce Product Stock and try again!');
            //     }

            //     $product_status = Product::getProductStatus($cart->product_id);
            //     if ($product_status==0) {
            //         Product::deleteCartProduct($cart->product_id,$user_email);
            //         return redirect('/cart')->with('flash_message_error','Disabled product removed from Cart. Please try again!');
            //     }

            //     $getCategoryId = Product::select('category_id')->where('id',$cart->product_id)->first();
            //     $category_status = Product::getCategoryStatus($getCategoryId->category_id);
            //     if ($category_status==0) {
            //         Product::deleteCartProduct($cart->product_id,$user_email);
            //         return redirect('/cart')->with('flash_message_error','One of the product category is disabled. Please try again!');
            //     }
            // }

            // Get Shipping Address of User
            $shippingDetails = DeliveryAddress::where(['user_email' => $user_email])->first();

            if (empty(Session::get('CouponCode'))) {
                $coupon_code = '';
            }else{
                $coupon_code = Session::get('CouponCode');
            }

            if (empty(Session::get('CouponAmount'))) {
                $coupon_amount = '';
            }else{
                $coupon_amount = Session::get('CouponAmount');
            }

            // $grand_total = Product::getGrandTotal();

            $order = new Order;
            $order->user_id = $user_id;
            $order->user_email = $user_email;
            $order->name = $user_name;
            $order->address = $shippingDetails->address;
            $order->city = $shippingDetails->city;
            $order->mobile = $shippingDetails->mobile;
            $order->coupon_code = $coupon_code;
            $order->coupon_amount = $coupon_amount;
            $order->order_status = "New";
            $order->payment_method = $data['payment_method'];
            $order->grand_total = $data['grand_total'];
            $order->save();

            $order_id = DB::getPdo()->lastInsertId();

            $cartProducts = DB::table('cart')->where(['user_email'=>$user_email])->get();
            foreach ($cartProducts as $pro) {
                $cartPro = new OrdersProduct;
                $cartPro->order_id = $order_id;
                $cartPro->user_id = $user_id;
                $cartPro->product_id = $pro->product_id;
                $cartPro->product_name = $pro->product_name;
                $cartPro->product_price = $pro->price;
                $cartPro->product_qty = $pro->quantity;
                $cartPro->save();

                // Reduce Stock Script Start
                // $getProductStock = ProductsAttribute::where('sku',$pro->product_code)->first();
                // $newStock = $getProductStock->stock - $pro->quantity;
                // ProductsAttribute::where('sku',$pro->product_code)->update(['stock'=>$newStock]);
                // Reduce Stock Script Ends
            }

            Session::put('order_id',$order_id);
            Session::put('grand_total',$data['grand_total']);

            if ($data['payment_method']=="Payme") {

                // Code for Order Email Start
                // $email = $user_email;
                // $messageData = [
                //     'email' => $email,
                //     'name' => $shippingDetails->name,
                //     'order_id' => $order_id,
                // ];
                // Mail::send('emails.order',$messageData,function($message) use($email){
                //     $message->to($email)->subject('Order Placed - E-com Website');
                // });
                // Code for Order Email End

                // Redirect user to thanks page after saving order
                return redirect('/payme');
            }else{
                // Paypal - Redirect user to paypal page after saving order
                return redirect('/paypal');
            }
            
        }
    }

    public function payme(Request $request){
        $user_email = Auth::user()->email;
        DB::table('cart')->where('user_email',$user_email)->delete();
        return view('orders.payme');
    }

    public function thanks(Request $request){
        $user_email = Auth::user()->email;
        DB::table('cart')->where('user_email',$user_email)->delete();
        return view('orders.thanks');
    }

    public function thanksPaypal(){
        return view('orders.thanks_paypal');
    }

    public function paypal(Request $request){
        $user_email = Auth::user()->email;
        DB::table('cart')->where('user_email',$user_email)->delete();
        return view('orders.paypal');
    }

    public function cancelPaypal(){
        return view('orders.cancel_paypal');
    }

    public function userOrders(){
        $user_id = Auth::user()->id;
        $orders = Order::with('orders')->where('user_id',$user_id)->orderBy('id','DESC')->get();
        return view('orders.user_orders')->with(compact('orders'));
    }

    public function userOrderDetails($order_id){
        $user_id = Auth::user()->id;
        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        $orderDetails = json_decode(json_encode($orderDetails));

        return view('orders.user_order_details')->with(compact('orderDetails'));

    }

    public function viewOrders(){
        $orders = Order::with('orders')->orderBy('id','Desc')->get();
        $orders = json_decode(json_encode($orders));
        return view('admin.orders.view_orders')->with(compact('orders'));
    }

    public function viewOrderDetails($order_id){
        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        //$orderDetails = json_decode(json_encode('orderDetails'));
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id',$user_id)->first();

        return view('admin.orders.order_details')->with(compact('orderDetails','userDetails'));
    }

    public function viewOrderInvoice($order_id){
        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        //$orderDetails = json_decode(json_encode('orderDetails'));
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id',$user_id)->first();

        return view('admin.orders.order_invoice')->with(compact('orderDetails','userDetails'));
    }

    public function viewPDFInvoice($order_id){
        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        //$orderDetails = json_decode(json_encode('orderDetails'));
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id',$user_id)->first();

        $output = '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Example 1</title>
    <style>
      .clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

body {
  position: relative;
  width: 21cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 90px;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
  background: url(dimension.png);
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 52px;
  margin-right: 10px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;        
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 20px;
  text-align: right;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}
    </style>
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="images/backend_images/logo.png">
      </div>
      <h1>INVOICE '.$orderDetails->id.'</h1>
      <div id="project" class="clearfix">
        <div><span>Order ID</span>'.$orderDetails->id.'</div>
        <div><span>Order Date</span>'.$orderDetails->created_at.'</div>
        <div><span>Order Amount</span>'.$orderDetails->grand_total.'</div>
        <div><span>Order Status</span>'.$orderDetails->order_status.'</div>
        <div><span>Payment</span>'.$orderDetails->payment_method.'</div>
      </div>
      <div id="project" style="float:right;">
        <div><strong>Shipping Address</strong></div>
        <div>'.$orderDetails->name.'</div>
        <div>'.$orderDetails->address.'</div>
        <div>'.$orderDetails->city.','.$orderDetails->state.'</div>
        <div>'.$orderDetails->pincode.'</div>
        <div>'.$orderDetails->country.'</div>
        <div>'.$orderDetails->mobile.'</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
            <tr>
                <td style="width: 20%"><strong>Product Code</strong></td>
                <td style="width: 20%" class="text-center"><strong>Size</strong></td>
                <td style="width: 20%" class="text-center"><strong>Color</strong></td>
                <td style="width: 20%" class="text-center"><strong>Price</strong></td>
                <td style="width: 20%" class="text-center"><strong>Qty</strong></td>
                <td style="width: 20%" class="text-right"><strong>Totals</strong></td>
            </tr>
        </thead>
        <tbody>';
            $subtotal = 0; 
            foreach($orderDetails->orders as $pro){ 
            $output .= '<tr>
                <td class="text-left">'.$pro->product_code.'</td>
                <td class="text-center">'.$pro->product_size.'</td>
                <td class="text-center">'.$pro->product_color.'</td>
                <td class="text-center">$ '.$pro->product_price.'</td>
                <td class="text-center">'.$pro->product_qty.'</td>
                <td class="text-right">$ '.$pro->product_price * $pro->product_qty.'</td>
            </tr>';
            $subtotal = $subtotal + ($pro->product_price * $pro->product_qty); 
            }
          $output .= '<tr>
            <td colspan="5">SUBTOTAL</td>
            <td class="total">$'.$subtotal.'</td>
          </tr>
          <tr>
            <td colspan="5">SHIPPING CHARGES (+)</td>
            <td class="total">$'.$orderDetails->shipping_charges.'</td>
          </tr>
          <tr>
            <td colspan="5">COUPON DISCOUNT (-)</td>
            <td class="total">$'.$orderDetails->coupon_amount.'</td>
          </tr>
          <tr>
            <td colspan="5" class="grand total">GRAND TOTAL</td>
            <td class="grand total">$'.$orderDetails->grand_total.'</td>
          </tr>
        </tbody>
      </table>
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>';

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($output);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();

    }

    public function updateOrderStatus(Request $request){
        if ($request->isMethod('post')) {
            $data = $request->all();
            Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);
            return redirect()->back()->with('flash_message_success','Order Status has been updated successfully!');
        }
    }

    public function deleteWishListProduct($id){
        DB::table('wish_list')->where('id',$id)->delete();
        return redirect()->back()->with('flash_message_success','Saralanganlardan o\'chirildi');
    }
}
