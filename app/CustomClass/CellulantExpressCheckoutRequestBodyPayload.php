<?php

namespace App\CustomClass;

class CellulantExpressCheckoutRequestBodyPayload
{
    /**
     * Class constructor.
     *
     * @return void
     */
    public $merchantTransactionID;

    public $customerFirstName;

    public $customerLastName;

    public $MSISDN;

    public $customerEmail;

    public $requestAmount;

    public $currencyCode;

    public $accountNumber;

    public $serviceCode;

    public $dueDate;

    public $requestDescription;

    public $countryCode;

    public $languageCode;

    public $successRedirectUrl;

    public $failRedirectUrl;

    public $paymentWebhookUrl;

    function __construct()
    {
        $merchantTransactionID = "2020052117070012";
        $customerFirstName = "John";
        $customerLastName = "Doe";
        $MSISDN = "254707198727";
        $customerEmail = "john.doe@example.com";
        $requestAmount = "100";
        $currencyCode = "KES";
        $accountNumber = "10092019";
        $serviceCode = "TESDEV2336";
        $dueDate = "2020-06-01 23:59:59";
        $requestDescription = "Dummy merchant transaction";
        $countryCode = "KE";
        $languageCode = "en";
        $successRedirectUrl = "https://google.com";
        $failRedirectUrl = "https://yahoo.com";
        $paymentWebhookUrl = "https://yahoo.com";
    }
}
