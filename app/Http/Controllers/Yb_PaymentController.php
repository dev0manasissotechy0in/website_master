<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentGateway\Paypal;
use App\PaymentGateway\Stripe;
use App\PaymentGateway\Razorpay;
use App\PaymentGateway\AuthorizeNet;
use Illuminate\Support\Facades\Session;
use DateTime;
use Illuminate\Support\Facades\DB;
use App\Models\Orders;

class Yb_PaymentController extends Controller
{
    public function yb_create(Request $request){
        // return $request->input();
        $pay_method = $request->pay_method;
        Session::put('pay_method', $pay_method);
        Session::put('items', $request->item);
        Session::put('amount', $request->amount);
        Session::put('tax_amount', $request->tax_amount);
        if($pay_method == 'paypal'){
            $paypal = new Paypal();
            return $paypal->checkout($request->total_amount);
        }
        if($pay_method == 'razorpay'){
            return $this->yb_paymentStatus($request);
        }
    }

    public function yb_store($response,$amount,$tax_amount){
        $items = Session::get('items');
        Session::forget('items'); 
        $products = DB::table('products')->select(['id','price','user'])->whereIn('id',$items)->get();
        // $amount = 
        // $total = 0;
        // foreach($products as $row){
        //     $total += $row->price;
        // } 
        $user = session()->get('user_sess');
        $order = new Orders();
        $order->user = $user;
        $order->pay_id = $response['payment_id'];
        $order->pay_method = Session::get('pay_method');
        $order->amount = $amount;
        $order->tax_amount = $tax_amount;
        $save_order = $order->save();
        
        foreach($products as $product){
            DB::table('order_products')->insert([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_price' => $product->price,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ]);
            $seller_amt = $product->price*seller_commission()/100;
            if($product->user != '1'){
                DB::table('seller_wallet')->insert([
                    'seller_id' => $product->user,
                    'type' => 'credit',
                    'amount' => $seller_amt,
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                ]);
            }
            
        }
        Session::forget('pay_method');
        Session::forget('amount');
        Session::forget('tax_amount');
        return $save_order;
    }

    public function yb_paymentStatus(Request $request){
        // return $request->input();
        $pay_method = Session::get('pay_method');
        if($pay_method == 'paypal'){
            $paypal = new Paypal();
            $response = $paypal->getPaymentStatus($request);
            // return $response;
            $amount = Session::get('amount');
            $tax_amount = Session::get('tax_amount');
            if(isset($response['success'])){
                $store = $this->yb_store($response,$amount,$tax_amount);
                if($store == '1'){
                    if(session()->has('user_sess')){
                        $user = session()->get('user_sess');
                        DB::table('user_cart')->where('user',$user)->delete();
                    }
                    return redirect('checkout/payment/success')->with('payment_success',$response['success']);
                }
            }else{
                return redirect('checkout/payment/failed')->with('payment_error',$response['error']);;
            }
        }elseif($pay_method == 'razorpay'){
            $razorpay = new Razorpay();
            $response = $razorpay->checkout($request->razor_payId);
            if(isset($response['success'])){
                $store = $this->yb_store($response,$request->amount,$request->tax_amount);
                if($store == '1'){
                    if(session()->has('user_sess')){
                        $user = session()->get('user_sess');
                        DB::table('user_cart')->where('user',$user)->delete();
                    }
                    return redirect('checkout/payment/success')->with('payment_success',$response['success']);
                }
            }else{
                return redirect('checkout/payment/failed')->with('payment_error',$response['error']);;
            }
        }
    }

    public function yb_paymentSuccess(){
        if(session()->has('payment_success')){
            return view('public.payment-success');
        }else{
            return redirect('/');
        }
    }

    public function yb_paymentFailed(){
        if(session()->has('payment_error')){
            return view('public.payment-failed');
        }else{
            return redirect('/');
        }
    }
}
