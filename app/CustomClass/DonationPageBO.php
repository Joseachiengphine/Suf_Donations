<?php

namespace App\CustomClass;

class DonationPageBO {
    public $pageName;

    public $donationCode;

    public $pageTitle;

    public $allowedCurrencies;

    public $salutations;

    public $cellulantExpressCheckoutRequestBodyPayload;

    public $countrys;

    public $relations;

    public $campaigns;

    public $accessKey;

    public $defaultRelation;

    public $defaultCampaign;

    public $donorDetails;

    public $graduationClass;
    
    public $expressCheckoutUrl;

    public function __construct()
    {
        $this->donorDetails = new DonorDetails();
    }
}
