<?php
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\SocialLinks;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\Pages;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;


if(! function_exists('admin_name')){
    function admin_name(){
        $admin = DB::table('admin')->pluck('admin_name')->first();
        return $admin;
    }
}

if(! function_exists('settings')){
    function settings(){
        $siteInfo = DB::table('general_settings')->first();
        return $siteInfo;
    }
}

if(! function_exists('site_name')){
    function site_name(){
        return settings()->site_name;
    }
}
if(! function_exists('site_logo')){
    function site_logo(){
        return settings()->site_logo;
    }
}
if(! function_exists('cur_format')){
    function cur_format(){
        return settings()->cur_format;
    }
}

if(! function_exists('copyright_text')){
    function copyright_text(){
        return settings()->copyright_txt;
    }
}

if(! function_exists('tax_percent')){
    function tax_percent(){
        return DB::table('payment_settings')->pluck('tax_percent')->first();
    }
}

if(! function_exists('seller_commission')){
    function seller_commission(){
        return DB::table('payment_settings')->pluck('commission')->first();
    }
}

if(! function_exists('seller_balance')){
    function seller_balance($seller){
        $credit = DB::table('seller_wallet')->select([DB::raw('SUM(amount) as credit_amount')])->where(['seller_id'=>$seller,'type'=>'credit'])->pluck('credit_amount')->first();
        $debit = DB::table('seller_wallet')->select([DB::raw('SUM(amount) as debit_amount')])->where(['seller_id'=>$seller,'type'=>'debit'])->pluck('debit_amount')->first();
        return $balance = $credit-$debit;
    }
}

if(! function_exists('social_links')){
    function social_links(){
        return SocialLinks::where('status','1')->get();
    }
}

if(! function_exists('product_categories')){
    function product_categories(){
        return ProductCategory::withCount('products')->where('status','1')->get();
    }
}

if(! function_exists('custom_pages')){
    function custom_pages(){
        return Pages::where('status','1')->get();
    }
}

if(! function_exists('get_cat_sub_categories')){
    function get_cat_sub_categories($cat){
        return ProductSubCategory::where(['category'=>$cat,'status'=>'1'])->get();
    }
}

if(! function_exists('wishlist_count')){
    function wishlist_count(){
        $count = 0;
        if(session()->has('user_sess')){
            $user = session()->get('user_sess');
            $wishlist = DB::table('user_wishlist')->where('user',$user)->count();
            $count += $wishlist;
        }
        return $count;
    }
}

if(! function_exists('user_wishlist')){
    function user_wishlist(){
        $wishlist = [];
        if(session()->has('user_sess')){
            $user = session()->get('user_sess');
            $wishlist = DB::table('user_wishlist')->where('user',$user)->pluck('product')->toArray();
        }
        return $wishlist;
    }
}

if(! function_exists('cart_count')){
    function cart_count(){
        $count = 0;
        if(session()->has('user_sess')){
            $user = session()->get('user_sess');
            $cart = DB::table('user_cart')->where('user',$user)->count();
            $count += $cart;
        }else{
            if(Cookie::has('userCart')){
                $cart = count(json_decode(Cookie::get('userCart')));
                $count += $cart;
            }
        }
        return $count;
    }
}

if(! function_exists('user_cart')){
    function user_cart(){
        $cart = [];
        if(session()->has('user_sess')){
            $user = session()->get('user_sess');
            $cart = DB::table('user_cart')->where('user',$user)->pluck('product')->toArray();
        }else{
            if(Cookie::has('userCart')){
                $cart = json_decode(Cookie::get('userCart'));
            }
        }
        return $cart;
    }
}

if(! function_exists('payment_gateway_list')){
    function payment_gateway_list(){
        return DB::table('payment_gateways')->where('status','1')->get();
    }
}



if (! function_exists('product_rating')) {
    function product_rating($id)
    {
        return DB::table('reviews')->select([DB::raw('COUNT(reviews.product_id) as rating_col'),DB::raw('SUM(reviews.rating) as rating_sum')])->where('product_id',$id)->first();
    }
}

if(! function_exists('approved_seller')){
    function approved_seller(){
        if(session()->get('user_type') == 'seller'){
            $uid = session()->get('user_sess');
            $approved = User::where('id',$uid)->pluck('approved_seller')->first();
            if($approved == '1'){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}


?>