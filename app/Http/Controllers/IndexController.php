<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use DateTime;
use Exception;
use App\Models\User;
use App\Models\Setting;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Relations;
use App\Models\Salutation;
use Illuminate\Http\Request;
use App\CustomClass\Checkout;
use App\Models\VcrunSupporter;
use App\Models\AllowedCurrency;
use App\Models\DonationRequest;
use App\Models\GraduationClass;
use App\Models\VcrunRegistration;
use App\CustomClass\DonationPageBO;
use App\Models\ParticipationOption;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\CampaignParticipation;
use App\Models\CellulantResponseRequest;
use App\CustomClass\DonationPageBoBuilder;
use App\CustomClass\CellulantExpressCheckoutRequestBodyPayload;
use App\CustomClass\CellulantExpressCheckoutRequestBodyPayloadBuilder;

class IndexController extends Controller
{

    private $countrys;
    private $fromDate;
    private $toDate;

    public function __construct()
    {
        try {
//            $this->countrys = Http::get('https://restcountries.eu/rest/v2/all');
//            $this->countrys = Http::get('https://raw.githubusercontent.com/mledoze/countries/master/dist/countries.json');
            $jsonString = json_decode(file_get_contents(base_path('resources/json/countries.json')));
//            Log::info(print_r($jsonString,true));
//            Log::info(print_r($this->countrys,true));
            $this->countrys = $jsonString->countries->country;
        }catch (Exception $exception){
            Log::error($exception);
        }
    }

    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function __invoke(Request $request)
    {
        $pageBo = $this->preparePageBo(null);
        $participationOption=ParticipationOption::all();
        return view('cellulantdonationpage')->with(['pageBo'=> $pageBo,'participation'=>$participationOption]);
//        if(!is_null($pageBo)) {
//
//        }
//        else {
//            return view('error500');
//        }
   }

    public function vcRunView()
    {
        $pageBo = $this->preparePageBo('VCRUN');
        $participationOption=ParticipationOption::all();
        $vcParticipants=VcrunRegistration::query()
            ->where('status','=','PAID')
            ->whereNotIn('request_merchant_id',['VC'])
            ->with('donationRequest')
            ->get();
        return view('vcrunform')->with(['pageBo'=> $pageBo,
            'participation'=>$participationOption,
            'vcRunParticipants'=>$vcParticipants
        ]);
//        if(!is_null($pageBo)) {
//
//        } else {
//            return view('error500');
//        }

    }

    //Report View
    public function reportView(Request $request)
    {
        if($request->session()->get('logged')){
            return view('report');
        }else {
            return view('login')->with('error','Please Log in First');

        }

    }

    //generate Report
    public function generateReport(Request $request)
    {
        $email=session()->get('username');
        if($this->checkEmail($email)){
            $fromDate=$request->dateFrom;
            $toDate=$request->dateTo;
            //Duplicate Query Body for pagination
            $report=\DB::table('donation_requests as dreqs')
                        ->select('dreqs.merchantID as MerchantID',
                        'dreqs.salutation as Salutation',
                        'dreqs.firstName as First_Name',
                        'dreqs.lastName as Last_Name',
                        'dreqs.phoneNumber as Phone_Number',
                        'dreqs.email as Email_Address',
                        'dreqs.zipCode as Zip_Code',
                        'dreqs.city as City',
                        'dreqs.country as Country',
                        'dreqs.campaign as Campaign',
                        'dreqs.relation as Donor_Relation',
                        'dreqs.requestDescription as Description',
                        'dreqs.currency as Currency',
                        'cresp.amountPaid as Request_Amount',
                        'dreqs.company as Company',
                        'dreqs.job_title as Job_Title',
                        'dreqs.graduation_class as Graduation_Class',
                        'dreqs.creation_date as Date_Time_Raised',
                        'dreqs.last_update as Date_Time_Submitted',
                        'cresp.checkOutRequestID as Response_Check_Out_Request_ID',
                        'cresp.accountNumber as Account_Number',
                        'cresp.requestStatusDescription as Response_Status_Description',
                        'cresp.currencyCode as Response_Currency_Code',
                        'cresp.amountPaid as Amount_Paid',
                        'cresp.last_update as Response_Date_Time'
                        )->leftJoin('cellulant_responses as cresp', 'dreqs.merchantID', '=', 'cresp.merchantTransactionID')
                        ->where('cresp.requestDate','>=',$fromDate)
                        ->where('cresp.requestDate','<=',$toDate)
                        ->paginate(10);

            if($report->isEmpty())
            {
                return view('report')->with('error','No Records Available');
            }
            else{
                //return $this->export($report);
                $report->withQueryString();
                return redirect()->route('report')->with(['reports'=>$report,
                                                        'fromDate'=>$fromDate,
                                                        'toDate'=>$toDate,
                                                        ]);
            }
        }else{
            $request->session()->flush();
            return view('login')->with('error','You are not authorised to access this system, contact your administrator');
        }


    }

    //Download report in CSV
    public function export($fromDate,$toDate)
    {

        $report=$this->dataQuery($fromDate,$toDate);
        $today = date("Y-m-d");
        $filename="suf_donations_".$fromDate."_".$toDate."_.csv";
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=".$filename,
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        //Setting column names
        $columns = array('Merchant ID',
                        'Salutation',
                        'First Name',
                        'Last Name',
                        'PhoneNumber',
                        'Email Address',
                        'Zip Code',
                        'City',
                        'Country',
                        'Campaign',
                        'Donor Relation',
                        'Description',
                        'Currency',
                        'Request Amount',
                        'Company',
                        'Job Title',
                        'Graduation Class',
                        'Date Raised',
                        'Date Submitted',
                        'Checkout ID',
                        'Account No',
                        'Response Status',
                        'Currency Code',


'Amount Paid',
                        'Response Date',
                    );

        $callback = function() use ($report, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($report as $item) {
                fputcsv($file, array($item->MerchantID,
                                $item->Salutation,
                                $item->First_Name,
                                $item->Last_Name,
                                $item->Phone_Number,
                                $item->Email_Address,
                                $item->Zip_Code,
                                $item->City,
                                $item->Country,
                                $item->Campaign,
                                $item->Donor_Relation,
                                $item->Description,
                                $item->Currency,
                                $item->Request_Amount,
                                $item->Company,
                                $item->Job_Title,
                                $item->Graduation_Class,
                                $item->Date_Time_Raised,
                                $item->Date_Time_Submitted,
                                $item->Response_Check_Out_Request_ID,
                                $item->Account_Number,
                                $item->Response_Status_Description,
                                $item->Response_Currency_Code,
                                $item->Amount_Paid,
                                $item->Response_Date_Time,
                            ));
            }
            fclose($file);
        };

        return \Response::stream($callback, 200, $headers);
    }

    public function dataQuery($fromDate,$toDate)
    {
        //Query
        $report=\DB::table('donation_requests as dreqs')
                    ->select('dreqs.merchantID as MerchantID',
                    'dreqs.salutation as Salutation',
                    'dreqs.firstName as First_Name',
                    'dreqs.lastName as Last_Name',
                    'dreqs.phoneNumber as Phone_Number',
                    'dreqs.email as Email_Address',
                    'dreqs.zipCode as Zip_Code',
                    'dreqs.city as City',
                    'dreqs.country as Country',
                    'dreqs.campaign as Campaign',
                    'dreqs.relation as Donor_Relation',
                    'dreqs.requestDescription as Description',
                    'dreqs.currency as Currency',
                    'cresp.amountPaid as Request_Amount',
                    'dreqs.company as Company',
                    'dreqs.job_title as Job_Title',
                    'dreqs.graduation_class as Graduation_Class',
                    'dreqs.creation_date as Date_Time_Raised',
                    'dreqs.last_update as Date_Time_Submitted',
                    'cresp.checkOutRequestID as Response_Check_Out_Request_ID',
                    'cresp.accountNumber as Account_Number',
                    'cresp.requestStatusDescription as Response_Status_Description',
                    'cresp.currencyCode as Response_Currency_Code',
                    'cresp.amountPaid as Amount_Paid',
                    'cresp.last_update as Response_Date_Time'
                    )->leftJoin('cellulant_responses as cresp', 'dreqs.merchantID', '=', 'cresp.merchantTransactionID')
                    ->where('cresp.requestDate','>=',$fromDate)
                    ->where('cresp.requestDate','<=',$toDate)
                    ->get();
            return $report;
    }

    //Login View
    public function loginView()
    {
        return view('login');
    }

    public function signupView()
    {
        return view('signup');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }



    public function checkEmail($email)
    {
        $allowedAdmins=config('app.admins');
        if(in_array($email,$allowedAdmins)){
            return true;
        }else{
            return false;
        }

    }

    //TODO::CAS Auth
    public function login_user(Request $request)
    {
        $email=$request->email;
        $password=$request->password;

        //get allowed users from config/app.php
        $allowedAdmins=config('app.admins');

        if(in_array($email,$allowedAdmins)){
            $user=User::where('email',$email)->get()->first();
            if($user->exists() && \Hash::check($password,$user->password)){
                $request->session()->put('logged',true);
                $request->session()->put('username',$email);
                return redirect()->route('report');
            }else{
                return view('login')->with('error','Check your username or password');
            }
        }
        else {
            return view('login')->with('error','Your email is not configured to access this system, contact your administrator');
        }
    }


    public function create_user(Request $request)
    {
        $email=$request->email;
        $password=$request->password;
        $existingUser=User::where('email',$email)->first();
        if($existingUser===null){
            $user=new User;
            $user->email=$email;
            $user->password=\Hash::make($password);
            $user->save();
            return view('login')->with('error','User Saved Successfully');
        }else{
            return view('signup')->with('error','That user already exists');
        }

    }

    public function paramPage($donationCode){
        $pageBo = $this->preparePageBo($donationCode);
        $participationOption=ParticipationOption::all();
        return view('cellulantdonationpage')->with(['pageBo'=> $pageBo,'participation'=>$participationOption]);
//        if(!is_null($pageBo)) {
//
//        } else {
//            return view('error500');
//        }
    }


    //PHP function that saves a donation request.
    //The function takes in a request object as a parameter, which contains information about the donation.
    public function saveDonationRequest(Request $request){
        Log::debug("SAVING REQUEST");

        //New DonationRequest object.
        $donationRequests = new DonationRequest();
        $donation = json_decode($request->getContent());
        Log::debug("Save Donation Details: ");
        Log::debug($request->getContent());
        $donationRequests->merchantID = $donation->merchantID;
        $donationRequests->firstName = $donation->firstName;
        $donationRequests->lastName = $donation->lastName;
        $donationRequests->company = $donation->company;
        $donationRequests->country = $donation->country;
        $donationRequests->city = $donation->city;
        $donationRequests->email = $donation->email;
        $donationRequests->zipCode = $donation->zipCode;
        $donationRequests->currency = $donation->currency;
//        $donationRequests->salutation = $donation->salutation;
        $donationRequests->salutation = "";
        $donationRequests->phoneNumber = $donation->phoneNumber;
        $donationRequests->requestDescription = $donation->requestDescription;
        $donationRequests->relation = $donation->relation;
        $donationRequests->campaign = $donation->campaign;
        $donationRequests->graduation_class = $donation->graduatingClass;
        $donationRequests->job_title = $donation->jobTitle;
        $donationRequests->save();

    }
    public function saveVcRunDonationRequest(Request $request) {
        Log::debug("SAVING VC RUN DONATION REQUEST");

        $donation = json_decode($request->getContent());
        Log::info(collect($donation));
        $donationRequests = new DonationRequest();
        Log::debug("Save Donation Details: ");
        Log::debug($request->getContent());
        $donationRequests->merchantID = $donation->merchantID;
        $donationRequests->firstName = $donation->firstName;
        $donationRequests->lastName = $donation->lastName;
        $donationRequests->company = $donation->company;
        $donationRequests->country = $donation->country;
        $donationRequests->city = $donation->city;
        $donationRequests->email = $donation->email;
        $donationRequests->zipCode = $donation->zipCode;
        $donationRequests->currency = $donation->currency;
//        $donationRequests->salutation = $donation->salutation;
        $donationRequests->salutation = "";
        $donationRequests->phoneNumber = $donation->phoneNumber;
        $donationRequests->requestDescription = $donation->requestDescription;
        $donationRequests->relation = $donation->relation;
        $donationRequests->campaign = Campaign::VC_RUN;
        $donationRequests->graduation_class = $donation->graduatingClass;
        $donationRequests->job_title = $donation->jobTitle;

        $donationRequests->save();

        // For each element of the donation Breakdown, save to appropriate table
        $donationBreakdown = $donation->donationBreakdown;
        foreach ($donationBreakdown as $item) {
            if ($item->merchantId ==='REGISTRATION') {
                $this->saveVcrunRegistration($donationRequests, $donation->registrationType, setting(Setting::REGISTRATION_AMOUNT,1000),$donation->raceKms);
                // Create a registration record
            } elseif ($item->merchantId ==='VC') {
                $this->saveSupportARunner($donationRequests,$item);
                // Create a vcrun_support record with the VC's Merchant ID (The VC should be pre-seeded in the system).
            } elseif (!$item->merchantId) {
                $this->saveSupportARunner($donationRequests,$item);
                // Save VCRun Support record with No one in particular to sponsor.
            } else {
                $this->saveSupportARunner($donationRequests, $item);
                // Find the user who matches the merchantID and link the vcrun_support record to them
            }
        }
    }

    private function saveSupportARunner($donationRequest, $donationData) {
        $model = new VcrunSupporter();
        $supportedMember = VcrunRegistration::query()->whereStatus('PAID')->where('request_merchant_id','=', $donationData->merchantId)->first();
        if ($supportedMember) {
            $model->supported_registrant_id = $supportedMember->id;
        }
        $model->request_merchant_id = $donationRequest->merchantID;
        $model->support_amount = $donationData->amount;
        $model->status = 'PENDING';
        $model->save();
    }

//    function saves the new instance of the VcrunRegistration model to the database.
    public function saveVcrunRegistration($donationRequest, $registrationType, $registrationAmount, $raceKms) {
        $model = new VcrunRegistration();
        $model->request_merchant_id = $donationRequest->merchantID;
        $model->participation_type = $registrationType;
        $model->registration_amount = floatval(setting(Setting::REGISTRATION_AMOUNT,1000));
        $model->race_kms = $raceKms;
        $model->status = 'PENDING';
        $model->matching_donor_id = setting(Setting::CURRENT_MATCHING_DONOR);
        $model->matched_amount = floatval(setting(Setting::MATCHING_PERCENTAGE,0))/100 * $model->registration_amount;
        $model->save();
    }

    public function saveCampaignOption(Request $request)
    {
        $option = json_decode($request->getContent());
        $merchantID=$option->merchantID;
        foreach($option->participationIDs as $participationID){
            CampaignParticipation::insert([
                'merchant_id'=>$merchantID,
                'participation_id'=>$participationID
            ]);
        }

    }
//    This prepares a Donation Page Business Object (pageBo) that is used to render a web page for accepting donations.
//    The function takes a single parameter, $donationCode, which is an optional code used to retrieve specific donation configuration settings from the database.
    function preparePageBo($donationCode){
        $pageBoBuilder = new DonationPageBoBuilder();
        $pageBoBuilder->addSalutations(Salutation::all());
        $pageBoBuilder->addAllowedCurrencies(AllowedCurrency::all());
        $pageBoBuilder->addGraduationClasses(GraduationClass::all());
        $campaign = Campaign::all();
        $relations = Relations::all();

        if(is_null($donationCode) || ((!is_null($donationCode)) && $donationCode != "")){
            if(Donation::where('donation_code', $donationCode)->count() > 0){
                $donationsConfigs = Donation::where('donation_code', $donationCode)->first();
                $dueDate= date_create(date("Y-m-d H:i:s"));
                $dueDate = date_add($dueDate,date_interval_create_from_date_string("{$donationsConfigs->due_date_duration_in_hours} hours"));
                $cellulantRequestBo = (new CellulantExpressCheckoutRequestBodyPayloadBuilder())
                    ->addCountryCode($donationsConfigs->country_code)
                    ->addMerchantTransactionID(date("YmdHis"))
//                    ->addAccountNumber($donationsConfigs->account_nbr)
                    ->addAccountNumber(date("YmdHis"))
                    ->addServiceCode($donationsConfigs->service_code)
                    ->addDueDate($dueDate->format('Y-m-d H:i:s'))
                    ->addLanguageCode($donationsConfigs->lang)
                    ->addFailRedirectUrl($donationsConfigs->fail_redirect_url)
                    ->addSuccessRedirectUrl($donationsConfigs->success_redirect_url)
                    ->addPaymentWebhookUrl($donationsConfigs->payment_web_hook)
                    ->getCellulantExpressCheckoutRequestBodyPayload();

                return $pageBoBuilder->addPageTitle($donationsConfigs->page_title)
                    ->addDonationCode($donationCode)
                    ->addCellulantRequestBo($cellulantRequestBo)
                    ->addAccessKey($donationsConfigs->access_key)
//                    ->addCountries(json_decode($this->countrys->body()))
                    ->addCountries($this->countrys)
                    ->addCampaigns($campaign)
                    ->addRelations($relations)
                    ->addDefaultCampaign($donationsConfigs->default_campaign)
                    ->addDefaultRelation($donationsConfigs->default_relation)
                    ->addExpressCheckoutLink($donationsConfigs->checkout_url)
                    ->getPageBo();
            }
        }

//        This function is responsible for preparing the data needed for a donation page, using both a passed donation code and a default code specified in the environment variables.
        $defaultDonationCode = env('DEFAULT_DONATION_CODE', "DEFAULT");
        if(Donation::where('donation_code', $defaultDonationCode)->count() > 0) {
            $donationsConfigs = Donation::where('donation_code', $defaultDonationCode)->first();
            $dueDate= date_create(date("Y-m-d H:i:s"));
            $dueDate = date_add($dueDate,date_interval_create_from_date_string("{$donationsConfigs->due_date_duration_in_hours} hours"));
            $cellulantRequestBo = (new CellulantExpressCheckoutRequestBodyPayloadBuilder())
                ->addCountryCode($donationsConfigs->country_code)
                ->addMerchantTransactionID(date("YmdHis"))
//                ->addAccountNumber($donationsConfigs->account_nbr)
                ->addAccountNumber(date("YmdHis"))
                ->addServiceCode($donationsConfigs->service_code)
                ->addDueDate($dueDate->format('Y-m-d H:i:s'))
                ->addLanguageCode($donationsConfigs->lang)
                ->addFailRedirectUrl($donationsConfigs->fail_redirect_url)
                ->addSuccessRedirectUrl($donationsConfigs->success_redirect_url)
                ->addPaymentWebhookUrl($donationsConfigs->payment_web_hook)
                ->getCellulantExpressCheckoutRequestBodyPayload();

            return $pageBoBuilder->addPageTitle($donationsConfigs->page_title)
                ->addDonationCode($defaultDonationCode)
                ->addCellulantRequestBo($cellulantRequestBo)
                ->addAccessKey($donationsConfigs->access_key)
//                ->addCountries(json_decode($this->countrys->body()))
                ->addCountries($this->countrys)
                ->addCampaigns($campaign)
                ->addRelations($relations)
                ->addDefaultCampaign($donationsConfigs->default_campaign)
                ->addDefaultRelation($donationsConfigs->default_relation)
                ->addExpressCheckoutLink($donationsConfigs->checkout_url)
                ->getPageBo();
        }

        return null;
    }


}
