<?php

namespace App\PaymentGateway;

use Stripe\Exception\CardException;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Validator;

/**
 * Class Stripe
 * @package App
 */
class Stripe
{
    private $stripe;
    public function __construct()
    {
        $this->stripe = new StripeClient(config('stripe.api_keys.secret_key'));
    }

    public function create($request){
        return redirect('stripe/'.$request->plan.'/checkout');
    }

    

    public function createToken($cardData,$amount)
    {
        // return $amount;
        $token = null;
        try {
            $token = $this->stripe->tokens->create([
                'card' => [
                    'number' => $cardData['cardNumber'],
                    'exp_month' => $cardData['month'],
                    'exp_year' => $cardData['year'],
                    'cvc' => $cardData['cvv']
                ]
            ]);
        } catch (CardException $e) {
            $token['error'] = $e->getError()->message;
        } catch (Exception $e) {
            $token['error'] = $e->getMessage();
        }
        if (!empty($token['error'])) {
            return ['error'=>$token['error']];
        }
        if (empty($token['id'])) {
            return ['error'=> 'Your Payment is Failed'];
        }
        return $this->createCharge($token['id'],$amount);
    }

    public function createCharge($tokenId, $amount)
    {
        // return $amount;
        $charge = null;
        try {
            $charge = $this->stripe->charges->create([
                'amount' => $amount*100,
                'currency' => 'inr',
                'source' => $tokenId,
                'description' => 'Subscription'
            ]);
        } catch (Exception $e) {
            return ['error'=>$e->getMessage()];
            // $charge['error'] = $e->getMessage();
        }
        // return $charge;
        if (!empty($charge) && $charge['status'] == 'succeeded') {
            return ['success'=>'Your Payment is Successfull','payment_id'=>$charge['id']];
        } else {
            return ['error'=>'Your Payment is Failed'];
        }
    }
}