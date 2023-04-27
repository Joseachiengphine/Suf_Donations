<?php


namespace App\CustomClass;


class DonorDetails
{
    public $firstName;

    public $lastName;

    public $company;

    public $country;

    public $city;

    public $email;

    public $zipCode;

    public $currency;

    public $salutation;

    public $phoneNumber;

    public $requestDescription;

    public $merchantID;

    public $registrationType;
    
    public $donationBreakdown;

    public function __construct()
    {
       $this->firstName="";
        $this->lastName="";
        $this->company="";
        $this->country="";
        $this->city="";
        $this->email="";
        $this->zipCode="";
        $this->currency="";
        $this->salutation="";
        $this->phoneNumber="";
        $this->requestDescription="";
        $this->merchantID = "";
        $this->registrationType="";
        $this->donationBreakdown=[];
    }

}
