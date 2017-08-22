<?php

namespace App;

use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Enum\CurrencyCode;
use Coinbase\Wallet\Value\Money;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Coinbase\Wallet\Resource\Transaction as TransactionBitCoin;

class Bitcoin extends Model
{
    public static function transferAmountToUser($data){
        $configuration = Configuration::apiKey(env('COINBASE_KEY'), env('COINBASE_SECRET'));
        $client = Client::create($configuration);
        $account = $client->getPrimaryAccount();

        $error = '';
        $timeoutError = false;

        $transaction = TransactionBitCoin::send([
            'toBitcoinAddress' => $data['address'],
            'amount'           => new Money($data['cc-amount'], CurrencyCode::USD),
            'description'      => $data['donate_amount']
        ]);

        try {
            $client->createAccountTransaction($account, $transaction);
        } catch(Exception $e) {
            $error = $e->getMessage();
        }

        if(!empty($error))
            return ['success'=>false,'timeout_error'=>$timeoutError,'message'=>$error];

        if(!empty($payResponse)){
            $ack = strtoupper($payResponse->responseEnvelope->ack);
            if($ack != "SUCCESS")
                return ['success'=>false,'timeout_error'=>$timeoutError,'message'=>"Something goes wrong. Please try again."];
            return ['success'=>true,'paymentResponse'=>$payResponse,'paykey'=>$payResponse->payKey,'status'=>$payResponse->paymentExecStatus];
        }
        else
            return ['success'=>true,'message'=>"Something goes wrong. Please try again."];

        /*$requestEnvelope = new RequestEnvelope("en_US");
        $paymentDetailsRequest = new PaymentDetailsRequest($requestEnvelope);
        $paymentDetailsRequest->payKey = "AP-44M68631YT6240058";
        $adaptivePaymentsService = new AdaptivePaymentsService(self::$sdkConfig);
        $paymentDetailsResponse = $adaptivePaymentsService->PaymentDetails($paymentDetailsRequest);
        dd($paymentDetailsResponse);*/
    }
}
