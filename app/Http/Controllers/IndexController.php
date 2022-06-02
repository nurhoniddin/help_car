<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Banner;

class IndexController extends Controller
{
    public function index(){

    	// In Descending order
    	// $productsAll = Product::get();

    	// In Descending order
    	// $productsAll = Product::orderBy('id','DESC')->get();

    	// In Random order
    	$featured = Product::inRandomOrder()->where('featured',1)->paginate(8);
    	$new = Product::inRandomOrder()->where('new',1)->paginate(12);
    	$popular = Product::inRandomOrder()->where('popular',1)->paginate(12);
    	$best = Product::inRandomOrder()->where('best',1)->paginate(12);

        // $catshirts = Product::inRandomOrder()->where('category_id',12)->paginate(6);

        // Get all Categories and Sub Categories
        $categories = Category::with('categories')->where(['parent_id'=>0])->get();
        // $categories_menu = "";
        // foreach($categories as $cat){
        // 	$categories_menu .= "<div class='panel-heading'>
								// 	<h4 class='panel-title'>
								// 		<a data-toggle='collapse' data-parent='#accordian' href='#".$cat->id."'>
								// 			<span class='badge pull-right'><i class='fa fa-plus'></i></span>
								// 			".$cat->name."
								// 		</a>
								// 	</h4>
								// </div>
        //                         <div id='".$cat->id."' class='panel-collapse collapse'>
								// 	<div class='panel-body'>
								// 		<ul>";
								// 				$sub_categories = Category::where(['parent_id'=>$cat->id])->get();
								// 	        	foreach($sub_categories as $subcat){
								// 	        		$categories_menu .= "<li><a href='".$subcat->url."'>".$subcat->name." </a></li>";
								// 	        	}
								// 		$categories_menu .= "</ul>
								// 	</div>
								// </div>
								// ";
        // }

        // $banners = Banner::where('status','1')->get();

        // Meta tags
        // $meta_title = "E-shop Sample Website";
        // $meta_description = "Online Shopping Site for Men, Women and Kids Clothing";
        // $meta_keywords = "eshop website, online shopping, men clothing";

    	return view('index')->with(compact('featured','new','popular','best','categories'));
    }
}
