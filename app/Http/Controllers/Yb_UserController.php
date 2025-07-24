<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as FacadeResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Mail;
use App\Mail\MailVerifyOtp;
use App\Models\Product;
use App\Models\Orders;
use App\Models\OrderProducts;
use App\Models\WithdrawMethod;
use App\Models\WithdrawRequest;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Pagination\Paginator;

class Yb_UserController extends Controller
{
    public function yb_index(Request $req){
        if($req->input()){
            $req->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = $req->input('email');
            $pass = $req->input('password');

            $login = User::where('email',$user)->first();
            if($login){
                if($login['status'] == '1'){
                    if(Hash::check($pass,$login->password)){
                        $req->session()->put('user_sess',$login->id);
                        $req->session()->put('user_type',$login->type);
                        if(Cookie::has('userCart') && $login->type == 'user'){
                            $cart = json_decode(Cookie::get('userCart'));
                            $count = count($cart);
                            if($count > 0){
                                for($i=0;$i<$count;$i++){
                                    $select = DB::table('user_cart')->where([
                                        'user' => $login->id,
                                        'product' => $cart[$i],
                                    ])->first();
                                    if(!$select){
                                        DB::table('user_cart')->insert([
                                            'user' => $login->id,
                                            'product' => $cart[$i],
                                        ]);
                                    }
                                }
                            }
                            Cookie::queue(Cookie::forget('userCart'));
                        }else{
                            Cookie::queue(Cookie::forget('userCart'));
                        }
                        return '1'; 
                    }else{
                        return 'Email Address and Password Not Matched.'; 
                    }
                }else{
                    return 'Your account is blocked by Site Administrator.'; 
                }
            }else{
                return 'Email Does Not Exists'; 
            }
        }else{
            if(!session()->has('user_sess')){
                return view('public.login');
            }else{
                return redirect('user-profile');
            }
        }
    }

    public function yb_logout(Request $request){
        $request->session()->forget('user_sess');
        $request->session()->forget('user_type');
        return redirect('/');
    }

    public function yb_create(){
        if(!session()->has('user_sess')){
            return view('public.signup');
        }else{
            return redirect('user-profile');
        }
    }

    public function yb_create_seller(){
        if(!session()->has('user_sess')){
            return view('public.seller-signup');
        }else{
            return redirect('user-profile');
        }
    }

    public function yb_store(Request $request){
        $request->validate([
            'name' => 'required',
            'unique_name' => 'required|unique:users,user_name',
            'email_address' => 'required|unique:users,email',
            'phone' => 'required',
            'password' => 'required',
            'country' => 'required',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->user_name = $request->unique_name;
        $user->slug = Str::slug($request->unique_name);
        $user->email = $request->email_address;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->country = $request->country;
        $user->type = $request->type;
        $user->remember_token = rand(00001,10000);
        $save = $user->save();
        
        Mail::to($user->email)->send( new MailVerifyOtp($user->remember_token));
        return array('result'=>$save,'id'=>Crypt::encrypt($user->email));
    }

    public function yb_signup_verify(Request $request,$text){
        $email = Crypt::decrypt($text);
        $token = User::where(['email'=>$email,'status'=>'0'])->pluck('remember_token')->first();
        if($request->input()){
            $request->validate([
                'otp' => 'required'
            ]);
            if($token == $request->otp){
                User::where('email',$email)->update([
                    'remember_token' => null,
                    'status' => '1'
                ]);
                $user = User::where('email',$email)->first();
                $request->session()->put('user_sess',$user->id);
                $request->session()->put('user_type',$user->type);
                if(Cookie::has('userCart') && $user->type == 'user'){
                    $cart = json_decode(Cookie::get('userCart'));
                    $count = count($cart);
                    if($count > 0){
                        for($i=0;$i<$count;$i++){
                            $select = DB::table('user_cart')->where([
                                'user' => $user->id,
                                'product' => $cart[$i],
                            ])->first();

                            if(!$select){
                                DB::table('user_cart')->insert([
                                    'user' => $user->id,
                                    'product' => $cart[$i],
                                ]);
                            }
                        }
                    }
                    Cookie::queue(Cookie::forget('userCart'));
                }else{
                    Cookie::queue(Cookie::forget('userCart'));
                }
                return '1';
            }else{
                return 'invalid otp';
            }
        }else{
            if($token){
                return view('public.signup-verify',compact('email'));
            }else{
                return abort('404');
            }
        }
    }

    public function yb_profile(){
        if(session()->has('user_sess')){
            $user = session()->get('user_sess');
            $profile = User::select(['name','image','user_name','email','phone','country','type','approved_seller','created_at'])
                        ->where('id',$user)->first(); 
            $products = Product::with('cat_name','author')->withCount('downloads')->where(['user'=>$user,'approved'=>'1','status'=>'1'])->get();
            $seller_products = Product::where('user',$user)->pluck('id')->toArray();
            $today_sales = 0;
            $total_sales = 0;
            $sales = Orders::with('products')->get();
            foreach($sales as $sale){
                foreach($sale->products as $product){
                    if(in_array($product->product_id,$seller_products)){
                        $total_sales++;
                        if(date('Y-m-d',strtotime($sale->created_at)) == date('Y-m-d')){
                            $today_sales++;
                        }
                    }
                }
            }
		    $revenue = Product::select(['products.price','products.id',DB::raw('COUNT(order_products.product_id) as product_total')])
            ->leftJoin('order_products','order_products.product_id','=','products.id')
            ->whereIn('products.id',$seller_products)
            ->groupBy('products.id')->get();
            $total_revenue = 0;
            foreach($revenue as $row){
                // echo $row->price;
                $total_revenue += ($row->price*$row->product_total);
            }
            // return $total_revenue;
            return view('public.user-profile',compact('profile','products','today_sales','total_sales','total_revenue'));
        }else{
            return redirect('login');
        }
    }

    public function yb_edit_profile(Request $request){
        if(session()->has('user_sess')){
            $user = session()->get('user_sess');
            $profile = User::where('id',$user)->first();
            if($request->input()){
                $request->validate([
                    'name' => 'required',
                    'unique_name' => 'required|unique:users,user_name,'.$user.',id',
                    'unique_slug' => 'required|unique:users,user_name,'.$user.',id',
                    'phone' => 'required',
                    'country' => 'required',
                ]);

                if($request->image != ''){        
                    $path = public_path().'/users/';
                    //code for remove old file
                    if($profile->image != ''  && $profile->image != null){
                        $file_old = $path.$profile->image;
                        if(file_exists($file_old)){
                            unlink($file_old);
                        }
                    }
                    //upload new file
                    $file = $request->image;
                    $image = str_replace(' ','-',strtolower($profile->user_name)).rand().$request->image->getClientOriginalName();
                    $file->move($path, $image);
                }else{
                    $image = $profile->image;
                }

                $update = User::where('id',$user)->update([
                    'name' => $request->name,
                    'user_name' => $request->unique_name,
                    'slug' => $request->unique_slug,
                    'image' => $image,
                    'phone' => $request->phone,
                    'country' => $request->country,
                ]);
                return $update;
            }else{
                return view('public.edit-profile',compact('profile'));
            }
        }else{
            return redirect('login');
        }
        
    }

    public function yb_forgot_password(Request $request){
        if(!session()->has('user_sess')){
            if($request->input()){
                $request->validate([
                    'email' => 'required|email|exists:users'
                ]);

                $exists = DB::table('password_reset_tokens')->where('email',$request->email)->first();
                if($exists){
                    return 'We have already e-mailed your password reset link!';
                }

                $user = User::where('email',$request->email)->select(['id','name','status'])->first();
                if($user){
                    if($user->status != '1'){
                        return 'Your account is blocked by Site Administrator';
                    }
                    $token = Str::random(64);
                    DB::table('password_reset_tokens')->insert([
                        'email' => $request->email, 
                        'token' => $token, 
                        'created_at' => Carbon::now()
                    ]);
                    Mail::send('public.mail.forgotPassword', ['token' => $token], function($message) use($request){
                        $message->to($request->email);
                        $message->subject('Reset Password');
                    });
                    return '1';
                }else{
                    return 'Email does not exists.';
                }
            }else{
                return view('public.forgot');
            }
        }else{
            return redirect('login');
        }
    }

    public function yb_reset_password($token){
        if($token){
            $email = DB::table('password_reset_tokens')->where('token',$token)->pluck('email')->first();
            return view('public.reset-password',compact('email','token'));
        }else{
            return abort('404');
        }
    }

    public function yb_update_user_password(Request $request){
        $request->input([
            'password' => 'required',
            'confirm_password' => 'required',
        ]);
        
        $check = DB::table('password_reset_tokens')->where(['email'=>$request->email,'token'=>$request->token])->first();
        if(!$check){
            return abort(404);
        }

        $reset = User::where('email',$request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')->where(['email'=>$request->email])->delete();
        return '1';
    }

    public function yb_change_password(Request $request){
        if(session()->has('user_sess')){
            if($request->input()){
                $request->validate([
                    'old_password' => 'required',
                    'password' => 'required',
                    'confirm_password' => 'required'
                ]);
                $uid = session()->get('user_sess');
                $user = User::where('id',$uid)->first();
                if(Hash::check($request->old_password,$user->password)){
                    $update = User::where('id',$uid)->update([
                        'password' => Hash::make($request->password)
                    ]);
                    $request->session()->forget('user_sess');
                    return $update;
                }else{
                    return 'Enter Correct Current Password.';
                }
            }else{
                return view('public.change-password');
            }
        }else{
            return redirect('login');
        }
    }

    public function yb_user_products(){
        if(session()->has('user_sess')){
            $user = session()->get('user_sess');
            $products = Product::with('cat_name','author')->withCount('downloads')->where(['user'=>$user])->get();
            return view('public.user-products',compact('products'));
        }else{
            return redirect('login');
        }
    }

    public function yb_add_wishlist(Request $request){
        if($request->product != '' && session()->has('user_sess')){
            $product = $request->product;
            $user = session()->get('user_sess');
            DB::table('user_wishlist')->insert([
                'user' => $user,
                'product' => $product,
            ]);
            return '1';
        }
    }

    public function yb_remove_wishlist(Request $request){
        if($request->product != '' && session()->has('user_sess')){
            $product = $request->product;
            $user = session()->get('user_sess');
            DB::table('user_wishlist')->where([
                'user' => $user,
                'product' => $product,
            ])->delete();
            return '1';
        }
    }

    public function yb_user_wishlist(){
        if(session()->has('user_sess')){
            $user = session()->get('user_sess');
            $user_wishlist = DB::table('user_wishlist')->where('user',$user)->pluck('product')->toArray();
            $products = Product::with('cat_name','author')->withCount('downloads')->whereIn('id',$user_wishlist)->get();
            return view('public.user-wishlist',compact('products'));
        }else{
            return redirect('login');
        }
        
    }

    public function yb_user_cart(){
        if(session()->has('user_sess')){
            $user = session()->get('user_sess');
            $user_cart = DB::table('user_cart')->where('user',$user)->pluck('product')->toArray();
        }else{
            if(Cookie::has('userCart')){
                $user_cart = json_decode(Cookie::get('userCart'));
            }else{
                $user_cart = [];
            }
        }
        $products = Product::with('cat_name','author')->withCount('downloads')->whereIn('id',$user_cart)->get();
        return view('public.user-cart',compact('products'));
    }

    public function yb_add_cart(Request $request){
        $product = $request->product;
        if(session()->has('user_sess')){
            $user = session()->get('user_sess');
            DB::table('user_cart')->insert([
                'user' => $user,
                'product' => $product,
            ]);
        }else{
            if($request->hasCookie('userCart')) {
                $cart = json_decode(Cookie::get('userCart'));
            }else{
                $cart = [];
            }
            array_push($cart,$product);
            $cart_str = json_encode($cart);
            Cookie::queue('userCart',$cart_str,5000000);
        }
        return '1';
    }

    public function yb_remove_cart(Request $request){
        $product = $request->product;
        if(session()->has('user_sess')){
            $user = session()->get('user_sess');
            DB::table('user_cart')->where(['user'=>$user,'product'=>$product])->delete();
        }else{
            $cart = json_decode(Cookie::get('userCart'));
            unset($cart[array_search($product, $cart)]);
            if(count($cart) > 0){
                $cart_str = json_encode($cart);
                Cookie::queue('userCart',$cart_str,5000000);
            }else{
                Cookie::forget('userCart');
            }
        }
        return '1';
    }

    public function yb_checkout(Request $request){
        if(session()->has('user_sess')){
            $items = $request->item;
            $products = Product::with('cat_name','author')->whereIn('id',$items)->where('status','1')->get();
            $payment_methods = DB::table('payment_gateways')->where('status','1')->get();
            return view('public.checkout',compact('products','payment_methods','items'));
        }else{
            return redirect('login');
        }
    }

    public function yb_user_downloads(Request $request){
        Paginator::useBootstrapFive();
        if(session()->has('user_sess')){
            $user = session()->get('user_sess');
            $product_ids = Orders::where('orders.user',$user)
            ->leftJoin('order_products','order_products.order_id','=','orders.id')
            ->pluck('order_products.product_id')
            ->toArray();
            $products = Product::with('cat_name','author')->withCount('downloads')->whereIn('id',$product_ids)->where('status','1')->paginate(10);
            return view('public.user_downloads',compact('products'));
        }else{
            return redirect('login');
        }
    }

    public function yb_product_download($slug){
        if(session()->has('user_sess')){
            $user = session()->get('user_sess');
            $product = Product::where('slug',$slug)->first();
            DB::table('user_downloads')->insert([
                'user_id'=>$user,
                'product_id'=>$product->id,
            ]);
            $file="./public/downloadable/".$product->download_file;
            return FacadeResponse::download($file);
        }else{
            return abort('404');
        }
    }

    public function yb_product_reviews(Request $request,$slug){
        if(session()->has('user_sess')){
            $user = session()->get('user_sess');
            $product = Product::where('slug',$slug)->first();
            if($request->input()){
                $review = htmlspecialchars(strip_tags($request->review));
                $save = DB::table('reviews')->insert([
                    'user_id' => $user,
                    'product_id' => $product->id,
                    'rating' => $request->rating,
                    'feedback' => $review,
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s')
                ]);
                return $save;
            }else{
                $reviews = DB::table('reviews')->select(['reviews.*','users.name'])
                ->leftJoin('users','users.id','=','reviews.user_id')
                ->where(['product_id'=>$product->id,'reviews.status'=>'1'])->latest()->get();
                return view('public.product-reviews',compact('product','reviews'));
            }
        }else{
            return redirect('login');
        }
    }

    public function yb_withdraw_requests(){
        if(session()->has('user_sess') && session()->get('user_type') == 'seller'){
            $requests = WithdrawRequest::with('method_name')->where('seller_id',session()->get('user_sess'))->latest()->get();
            return view('public.withdraw-requests',compact('requests'));
        }else{
            return redirect('login');
        }
    }

    public function yb_new_withdraw_request(){
        if(session()->has('user_sess') && session()->get('user_type') == 'seller'){
            $methods = WithdrawMethod::where('status','1')->get();
            return view('public.create-withdraw-request',compact('methods'));
        }else{
            return redirect('login');
        }
    }

    public function yb_submit_withdraw_request(Request $request){
        if(session()->has('user_sess') && session()->get('user_type') == 'seller'){
            $request->validate([
                'method' => 'required',
                'amount' => 'required',
            ]);
            $method_details = WithdrawMethod::where('id',$request->method)->first();
            $seller_balance = seller_balance(session()->get('user_sess'));
            if($request->amount > $seller_balance){
                return 'Amount is Higher then your wallet balance.';
            }
            if($request->amount > $method_details->max_amount){
                return 'Amount is Higher then Max Amount Withdrawal Limit.';
            }
            if($request->amount < $method_details->min_amount){
                return 'Amount is Lower then Min Amount Withdrawal Limit.';
            }
            $charge_amount = $request->amount*$method_details->charge/100;

            $req = new WithdrawRequest();
            $req->seller_id = session()->get('user_sess');
            $req->method = $request->method;
            $req->amount = $request->amount;
            $req->charge_amount = $charge_amount;
            $req->status = '0';
            $save = $req->save();
            return $save;
        }else{
            return redirect('login');
        }
    }

    public function yb_seller_wallet(){
        $user = session()->get('user_sess');
        $wallet = Db::table('seller_wallet')->where('seller_id',$user)->latest()->get();
        return view('public.seller-wallet',compact('wallet'));
    }
}
