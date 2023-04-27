<?php


namespace App\CustomClass;


class CellulantExpressCheckoutRequestBodyPayloadBuilder
{
    private $cellulantExpressCheckoutRequestBodyPayload;

    function __construct()
    {
        $this->cellulantExpressCheckoutRequestBodyPayload = new CellulantExpressCheckoutRequestBodyPayload();
    }

    public function addMerchantTransactionID($merchantTransactionID){
        $this->cellulantExpressCheckoutRequestBodyPayload->merchantTransactionID = $merchantTransactionID;
        return $this;
    }
    public function addCustomerFirstName($customerFirstName){
        $this->cellulantExpressCheckoutRequestBodyPayload->customerFirstName = $customerFirstName;
        return $this;
    }
    public function addCustomerLastName($customerLastName){
        $this->cellulantExpressCheckoutRequestBodyPayload->customerLastName = $customerLastName;
        return $this;
    }
    public function addMSISDN($MSISDN){
        $this->cellulantExpressCheckoutRequestBodyPayload->MSISDN = $MSISDN;
        return $this;
    }
    public function addCustomerEmail($customerEmail){
        $this->cellulantExpressCheckoutRequestBodyPayload->customerEmail = $customerEmail;
        return $this;
    }
    public function addRequestAmount($requestAmount){
        $this->cellulantExpressCheckoutRequestBodyPayload->requestAmount = $requestAmount;
        return $this;
    }
    public function addCurrencyCode($currencyCode){
        $this->cellulantExpressCheckoutRequestBodyPayload->currencyCode =$currencyCode;
        return $this;
    }
    public function addAccountNumber($accountNumber){
        $this->cellulantExpressCheckoutRequestBodyPayload->accountNumber=$accountNumber;
        return $this;
    }
    public function addServiceCode($serviceCode){
        $this->cellulantExpressCheckoutRequestBodyPayload->serviceCode=$serviceCode;
        return $this;
    }
    public function addDueDate($dueDate){
        $this->cellulantExpressCheckoutRequestBodyPayload->dueDate=$dueDate;
        return $this;
    }
    public function addRequestDescription($requestDescription){
        $this->cellulantExpressCheckoutRequestBodyPayload->requestDescription=$requestDescription;
        return $this;
    }
    public function addCountryCode($countryCode){
        $this->cellulantExpressCheckoutRequestBodyPayload->countryCode=$countryCode;
        return $this;
    }
    public function addLanguageCode($languageCode){
        $this->cellulantExpressCheckoutRequestBodyPayload->languageCode=$languageCode;
        return $this;
    }
    public function addSuccessRedirectUrl($successRedirectUrl){
        $this->cellulantExpressCheckoutRequestBodyPayload->successRedirectUrl=$successRedirectUrl;
        return $this;
    }
    public function addFailRedirectUrl($failRedirectUrl){
        $this->cellulantExpressCheckoutRequestBodyPayload->failRedirectUrl=$failRedirectUrl;
        return $this;
    }
    public function addPaymentWebhookUrl($paymentWebhookUrl){
        $this->cellulantExpressCheckoutRequestBodyPayload->paymentWebhookUrl=$paymentWebhookUrl;
        return $this;
    }
    public function getCellulantExpressCheckoutRequestBodyPayload(){
        return $this->cellulantExpressCheckoutRequestBodyPayload;
    }
}
