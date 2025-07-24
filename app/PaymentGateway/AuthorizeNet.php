<?php

namespace App\PaymentGateway;

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

/**
 * Class AuthorizeNet
 * @package App
 */
class AuthorizeNet
{
    

    public function create($request){
        return redirect('authorize/'.$request->plan.'/checkout');
    }

    

    public function checkout($cardData,$amount)
    {
        $input = $cardData;
        /* Create a merchantAuthenticationType object with authentication details
          retrieved from the constants file */
          $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
          $merchantAuthentication->setName(env('MERCHANT_LOGIN_ID'));
          $merchantAuthentication->setTransactionKey(env('MERCHANT_TRANSACTION_KEY'));
  
          // Set the transaction's refId
          $refId = 'ref' . time();
          $cardNumber = preg_replace('/\s+/', '', $input['cardNumber']);
          
          // Create the payment data for a credit card
          $creditCard = new AnetAPI\CreditCardType();
          $creditCard->setCardNumber($cardNumber);
          $creditCard->setExpirationDate($input['year'] . "-" .$input['month']);
          $creditCard->setCardCode($input['cvv']);
  
          // Add the payment data to a paymentType object
          $paymentOne = new AnetAPI\PaymentType();
          $paymentOne->setCreditCard($creditCard);
  
          // Create a TransactionRequestType object and add the previous objects to it
          $transactionRequestType = new AnetAPI\TransactionRequestType();
          $transactionRequestType->setTransactionType("authCaptureTransaction");
          $transactionRequestType->setAmount($amount);
          $transactionRequestType->setPayment($paymentOne);
  
          // Assemble the complete transaction request
          $requests = new AnetAPI\CreateTransactionRequest();
          $requests->setMerchantAuthentication($merchantAuthentication);
          $requests->setRefId($refId);
          $requests->setTransactionRequest($transactionRequestType);
  
          // Create the controller and get the response
          $controller = new AnetController\CreateTransactionController($requests);
          $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
          if ($response != null) {
              // Check to see if the API request was successfully received and acted upon
              if ($response->getMessages()->getResultCode() == "Ok") {
                  // Since the API request was successful, look for a transaction response
                  // and parse it to display the results of authorizing the card
                  $tresponse = $response->getTransactionResponse();
                  if ($tresponse != null && $tresponse->getMessages() != null) {
                    
                      return ['success'=>'Your Payment is Successful', 'payment_id'=>$tresponse->getTransId()];  
                      
                  } else {
                      $message_text = 'Your Payment is Failed';
  
                      if ($tresponse->getErrors() != null) {
                          $message_text = $tresponse->getErrors()[0]->getErrorText();
                      }
                      return ['error'=>$message_text];
                  }
                  // Or, print errors if the API request wasn't successful
              } else {
                  $message_text = 'Your Payment is Failed';
  
                  $tresponse = $response->getTransactionResponse();
  
                  if ($tresponse != null && $tresponse->getErrors() != null) {
                      $message_text = $tresponse->getErrors()[0]->getErrorText();
                  } else {
                        if($response->getMessages()->getMessage()[0]->getCode() == "E00003"){
                            $message_text = 'Card Number is invalid.';
                        }else{
                            $message_text = $response->getMessages()->getMessage()[0]->getText();
                        }
                  }       
                  return ['error'=>$message_text];         
              }
          } else {
              $message_text = 'Your Payment is Failed';
              return ['error'=>$message_text];
          }
    }

    
}