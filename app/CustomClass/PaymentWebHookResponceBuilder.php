<?php


namespace App\CustomClass;


class PaymentWebHookResponceBuilder
{
    private $paymentWebHookResponce;

    public function __construct()
    {
        $this->paymentWebHookResponce = new PaymentWebHookResponce();
    }

    public function addCheckoutRequestID($checkoutRequestID){
        $this->paymentWebHookResponce->checkoutRequestID = $checkoutRequestID;
        return $this;
    }

    public function addMerchantTransactionID($merchantTransactionID){
        $this->paymentWebHookResponce->merchantTransactionID = $merchantTransactionID;
        return $this;
    }
    public function addStatusCode($statusCode){
        $this->paymentWebHookResponce->statusCode=$statusCode;
        return $this;
    }

    public function addStatusDescription($statusDescription){
        $this->paymentWebHookResponce->statusDescription=$statusDescription;
        return $this;
    }
    public function addReceiptNumber($receiptNumber){
        $this->paymentWebHookResponce->receiptNumber = $receiptNumber;
        return $this;
    }
    public function getPaymentWebHookResponce(){
        return $this->paymentWebHookResponce;
    }
}
