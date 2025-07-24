<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Pages;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\User;
use App\Models\Testimonials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Mail\SubscribeMailVerify;
use App\Models\ProductTags;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Pagination\Paginator;

class Yb_HomeController extends Controller
{
    public function yb_index(){
        $home_sections = DB::table('homepage_settings')->where('status','1')->get();
        $featured = Product::with('cat_name','author')->withCount('downloads')->where(['featured'=>'1','status'=>'1'])->latest()->get();
        $latest = Product::with('cat_name','author')->withCount('downloads')->where(['status'=>'1'])->latest()->get();
        $blogs = Blog::with('cat_name')->where('status','1')->latest()->limit(6)->get();
        $testimonials = Testimonials::where('status','1')->get();
        $banner = DB::table('banner')->first();
        return view('public.index',compact('home_sections','latest','featured','blogs','testimonials','banner'));
    }

    public function yb_blogs(){
        $category = BlogCategory::withCount('blogs')->get();
        //Edited Line - Added Latest
        $blogs = Blog::with('cat_name')->where('status','1')->latest()->get();
        
        // $related = Blog::with('cat_name')->where(['category'=>$blog->cat_name->id,'status'=>'1'])->get();
        return view('public.blogs',compact('blogs','category'));
    }

    public function yb_category_blogs($slug){
        $cat_detail = BlogCategory::where('slug',$slug)->first();
        if($cat_detail){
            $category = BlogCategory::withCount('blogs')->get();
            $blogs = Blog::with('cat_name')->where(['category'=>$cat_detail->id,'status'=>'1'])->latest()->get();
            return view('public.category-blogs',compact('blogs','category','cat_detail'));
        }else{
            return abort(404);
        }
    }

    public function yb_single_blog($slug){
        $category = BlogCategory::withCount('blogs')->get();
        $blog = Blog::with('cat_name')->where(['slug'=>$slug,'status'=>
        '1'])->first();
        $related = Blog::with('cat_name')->where(['category'=>$blog->cat_name->id,'status'=>'1'])->get();
        return view('public.blog-single',compact('blog','category','related'));
    }

    public function yb_all_products(Request $request){
        $search = '';
        if($request->input() && $request->s != ''){
            $search = str($request->s)->squish();
        }
        Paginator::useBootstrapFive();
        $category = ProductCategory::withCount('products')->where('status','1')->get();
        if($search != ''){
            $products = Product::with('cat_name','author')->withCount('downloads')->where('title','LIKE',"%$search%")->where('status','1')->paginate(3);
        }else{
            $products = Product::with('cat_name','author')->withCount('downloads')->where('status','1')->latest()->paginate(6);
        }
        return view('public.all-products',compact('category','products'));
    }

    public function yb_category_products(Request $request,$slug){
        $search = '';
        if($request->input() && $request->s != ''){
            $search = str($request->s)->squish();
        }
        // return $search;
        $cat_detail = ProductCategory::where('slug',$slug)->first();
        if($cat_detail){
            $sub_category = ProductSubCategory::withCount('products')->where('category',$cat_detail->id)->get();
            $category = ProductCategory::withCount('products')->where('status','1')->get();
            if($search != ''){
                // return $search;
                $products = Product::with('cat_name','author')->withCount('downloads')->where('title','LIKE',"%$search%")->where(['category'=>$cat_detail->id,'status'=>'1'])->get();
            }else{
                $products = Product::with('cat_name','author')->withCount('downloads')->where(['category'=>$cat_detail->id,'status'=>'1'])->get();
            }
            // return $products;
            return view('public.category-products',compact('category','products','cat_detail','sub_category'));
        }else{
            return abort('404');
        }
    }

    public function yb_subcategory_products($text,$slug){
        $cat_detail = ProductCategory::where('slug',$text)->first();
        $sub_cat_detail = ProductSubCategory::where('slug',$slug)->first();
        if($cat_detail && $sub_cat_detail){
            $category = ProductCategory::withCount('products')->where('status','1')->get();
            $sub_category = ProductSubCategory::withCount('products')->where('category',$cat_detail->id)->get();
            $products = Product::with('cat_name','author')->withCount('downloads')->where(['category'=>$cat_detail->id,'status'=>'1'])->get();
            return view('public.subcategory-products',compact('category','products','cat_detail','sub_cat_detail','sub_category'));
        }else{
            return abort('404');
        }
    }

    public function yb_tag_products($slug){
        $tag_detail = ProductTags::where('slug',$slug)->first();
        if($tag_detail){
            $category = ProductCategory::withCount('products')->where('status','1')->get();
            $products = Product::with('cat_name','author')->withCount('downloads')
            ->whereRaw("find_in_set($tag_detail->id,tags)")->where('status','1')->get();
            return view('public.tag-products',compact('category','products','tag_detail'));
        }else{
            return abort('404');
        }
    }

    public function yb_custom_page($slug){
        $page = Pages::where('slug',$slug)->first();
        if($page){
            return view('public.custom',compact('page'));
        }else{
            return abort(404);
        }
    }


    public function yb_seller_products($slug){
        $user = User::where('user_name',$slug)->first();
        $products = Product::with('cat_name','author')->withCount('downloads')->where(['user'=>$user->id,'status'=>'1','approved'=>'1'])->get();
        return view('public.seller_products',compact('user','products'));
    }


    public function yb_single_product($slug){
        $product = Product::with('cat_name','subcat_name','author')->withCount('downloads')
        ->select('products.*',DB::raw('GROUP_CONCAT(DISTINCT product_tags.name ORDER BY products.tags ASC) as tag_list'),DB::raw('GROUP_CONCAT(DISTINCT product_tags.slug ORDER BY products.tags ASC) as tag_slugs'))
        ->leftJoin("product_tags", DB::raw("FIND_IN_SET(product_tags.id, products.tags)"), ">", DB::raw("'0'"))
        ->where('products.slug',$slug)
        ->groupBy('products.id')
        ->first();
        $reviews = DB::table('reviews')->select(['reviews.*','users.name'])
                ->leftJoin('users','users.id','=','reviews.user_id')
                ->where(['product_id'=>$product->id,'reviews.status'=>'1'])->latest()->get();
        return view('public.product_single',compact('product','reviews'));
    }

    public function yb_subscribe_email(Request $request){
        $email = $request->email;
        $select = DB::table('newsletter_subscribers')->where('email',$email)->first();
        if($select){
            return $email.' is already subscribed.';
        }
        $token = Crypt::encrypt($email);
        Mail::to($email)->send( new SubscribeMailVerify($token));
        $save = DB::table('newsletter_subscribers')->insert([
            'email' => $email,
            'verified' => $token,
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s'),
        ]);
        if($save == '1'){
            return $save;
        }else{
            return 'Not Submited. Try Again Later.';
        }
    }

    public function yb_subscribe_email_verify($token){
        $email = Crypt::decrypt($token);
        $select = DB::table('newsletter_subscribers')->where(['email'=>$email,'verified'=>$token])->first();
        if($select){
            $update = DB::table('newsletter_subscribers')->where(['email'=>$email])->update([
                'verified' => '1'
            ]);
            if($update == '1'){
                return view('public.email_verified');
            }else{
                return abort(404);
            }
        }else{
            return abort(404);
        }
    }

    // public function yb_author_profile($text){
    //     $name = str_replace('@','',$text);
    //     $user = User::where('slug',$name)->first();
    //     return $user;
    // }

    public function yb_get_search_autocomplete(Request $request){
        $txt = str($request->val)->squish();
        $category = ProductCategory::withCount('products')->where('status','1')->get();
        return view('public.partials.search-autocomplete',compact('category','txt'));
    }
}
