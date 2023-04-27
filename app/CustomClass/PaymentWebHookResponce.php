<?php


namespace App\CustomClass;


class PaymentWebHookResponce
{
    public $checkoutRequestID;

    public $merchantTransactionID;

    public $statusCode;

    public $statusDescription;
    
    public $receiptNumber;
}
