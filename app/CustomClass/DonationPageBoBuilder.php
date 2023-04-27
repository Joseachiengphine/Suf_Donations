<?php


namespace App\CustomClass;


class DonationPageBoBuilder
{
    private $pageBo;

    function __construct()
    {
        $this->pageBo = new DonationPageBO();
    }

    public function addPageTitle($pageTitle){
        $this->pageBo->pageTitle = $pageTitle;
        return $this;
    }

    public function addGraduationClasses($pageTitle){
        $this->pageBo->graduationClass = $pageTitle;
        return $this;
    }

    public function addDonationCode($donationCode){
        $this->pageBo->donationCode = $donationCode;
        return $this;
    }
    public function addDonorDetails($donorDetails){
        $this->pageBo->donorDetails = $donorDetails;
        return $this;
    }
    public function addAllowedCurrencies($allowedCurrencies){
        $this->pageBo->allowedCurrencies = $allowedCurrencies;
        return $this;
    }

    public function addSalutations($salutations){
        $this->pageBo->salutations = $salutations;
        return $this;
    }

    public function addCellulantRequestBo($cellulantExpressCheckoutRequestBodyPayload){
        $this->pageBo->cellulantExpressCheckoutRequestBodyPayload = $cellulantExpressCheckoutRequestBodyPayload;
        return $this;
    }
    public function addCountries($countries){
        $this->pageBo->countrys = $countries;
        return $this;
    }

    public function addAccessKey($accessKey){
        $this->pageBo->accessKey = $accessKey;
        return $this;
    }

    public function addExpressCheckoutLink($url){
        $this->pageBo->expressCheckoutUrl = $url;
        return $this;
    }

    public function addCampaigns($campaigns){
        $this->pageBo->campaigns = $campaigns;
        return $this;
    }

    public function addRelations($relations){
        $this->pageBo->relations = $relations;
        return $this;
    }

    public function addDefaultRelation($relation){
        $this->pageBo->defaultRelation = $relation;
        return $this;
    }

    public function addDefaultCampaign($campaign){
        $this->pageBo->defaultCampaign = $campaign;
        return $this;
    }

    public function getPageBo(){
        return $this->pageBo;
    }
}
