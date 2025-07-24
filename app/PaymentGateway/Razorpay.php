<?php

namespace App\PaymentGateway;

use Razorpay\Api\Api;
use Illuminate\Support\Facades\Session;
use Exception;

/**
 * Class Razorpay
 * @package App
 */
class Razorpay
{
    public function checkout($pay_id){
        $api = new Api(env('RAZOR_KEY'),env('RAZOR_SECRET')); 
    
          $payment = $api->payment->fetch($pay_id);
  
          if(!empty($pay_id)) {
              try {
                  $response = $api->payment->fetch($pay_id)->capture(array('amount'=>$payment['amount'])); 
                  return ['success'=> 'Your Payment is Successfull','payment_id'=>$pay_id];
  
              } catch (Exception $e) {
                return ['error'=> $e->getMessage()];
              }
          }
    }

    
}