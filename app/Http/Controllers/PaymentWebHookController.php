<?php

namespace App\Http\Controllers;

use App\Models\CellulantResponseRequest;
use App\CustomClass\CellulantExpressCheckoutRequestBodyPayloadBuilder;
use App\CustomClass\DonationPageBoBuilder;
use App\CustomClass\PaymentWebHookResponce;
use App\CustomClass\PaymentWebHookResponceBuilder;
use App\Models\DonationRequests;
use App\Models\Donations;
use App\Models\Salutation;
use App\Models\VcrunSupporter;
use Exception;
use Illuminate\Http\Request;
use App\CustomClass\Checkout;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

use App\CustomClass\DonationPageBO;
use App\CustomClass\CellulantExpressCheckoutRequestBodyPayload;
use Illuminate\Support\Facades\Http;
use App\Models\AllowedCurrency;

class PaymentWebHookController extends Controller
{


    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse|Response
     */
//PHP function that is called when a payment webhook is received.
    public function __invoke(Request $request)
    {
        $responseCode = "";
        try {
//            Logs the content of the request for debugging purposes.
            Log::debug($request->getContent());
            if (!is_null($request->getContent())) {
                $paymentWebHookRequest = json_decode($request->getContent());
                if($paymentWebHookRequest->requestStatusCode == "129"){
                    $responseCode = "";
                } else if($paymentWebHookRequest->requestStatusCode == "176" ) {
                    $responseCode = "188";
                } else if($paymentWebHookRequest->requestStatusCode == "178"){
                    $responseCode = "183";
                } else if($paymentWebHookRequest->requestStatusCode == "179"){
                    $responseCode = "188";
                } else if($paymentWebHookRequest->requestStatusCode == "99"){
                    $responseCode = "188";
                }
                //New object of CellulantResponseRequest class, sets its properties with the decoded JSON payload, and saves it to the database.
                $cellulantResponseRequest = new CellulantResponseRequest();
                $cellulantResponseRequest->checkOutRequestID = $paymentWebHookRequest->checkoutRequestID;
                $cellulantResponseRequest->merchantTransactionID = $paymentWebHookRequest->merchantTransactionID;
                $cellulantResponseRequest->requestStatusCode = $paymentWebHookRequest->requestStatusCode;
                $cellulantResponseRequest->requestStatusDescription = $paymentWebHookRequest->requestStatusDescription;
                $cellulantResponseRequest->MSISDN = $paymentWebHookRequest->MSISDN;
                $cellulantResponseRequest->serviceCode = $paymentWebHookRequest->serviceCode;
                $cellulantResponseRequest->accountNumber = $paymentWebHookRequest->accountNumber;
                $cellulantResponseRequest->currencyCode = $paymentWebHookRequest->currencyCode;
                $cellulantResponseRequest->amountPaid = $paymentWebHookRequest->amountPaid;
                $cellulantResponseRequest->requestCurrencyCode = $paymentWebHookRequest->currencyCode;
                $cellulantResponseRequest->requestAmount = $paymentWebHookRequest->requestAmount;
                $cellulantResponseRequest->requestDate = $paymentWebHookRequest->requestDate;
                $cellulantResponseRequest->payments = json_encode($paymentWebHookRequest->payments);
                $cellulantResponseRequest->save();
//New object of PaymentWebHookResponceBuilder class and sets its properties with the appropriate values.
                $paymentWebHookResponce = new PaymentWebHookResponceBuilder();
                $paymentWebHookResponce->addMerchantTransactionID($paymentWebHookRequest->merchantTransactionID)
                    ->addCheckoutRequestID($paymentWebHookRequest->checkoutRequestID)
                    ->addStatusCode($responseCode)
                    ->addStatusDescription($paymentWebHookRequest->requestStatusDescription)
                    ->addReceiptNumber($paymentWebHookRequest->merchantTransactionID);
                return response()->json($paymentWebHookResponce->getPaymentWebHookResponce(), 200);
            } else {
                $responseCode = "189";
                Log::debug("Request body has no contents");
                $paymentWebHookResponce = new PaymentWebHookResponceBuilder();
                $paymentWebHookResponce->addMerchantTransactionID("1234433434")
                    ->addCheckoutRequestID("383997")
                    ->addStatusCode($responseCode)
                    ->addStatusDescription("Status")
                    ->addReceiptNumber(now());
                return response()->json($paymentWebHookResponce->getPaymentWebHookResponce(), 200);
            }
            // Returns a JSON response with the payment webhook response data.
        } catch (Exception $e) {
            $responseCode = "189";
            $paymentWebHookResponse = new PaymentWebHookResponceBuilder();
            $paymentWebHookResponse->addMerchantTransactionID("1234433434")
                ->addCheckoutRequestID("383997")
                ->addStatusCode($responseCode)
                ->addStatusDescription("Status")
                ->addReceiptNumber(now());
            return response()->json($paymentWebHookResponse->getPaymentWebHookResponce(), 200);
        }
    }

    public function vcrunResponse(Request $request)
    {
        $responseCode = "";
        try {
            Log::debug($request->getContent());
            if (!is_null($request->getContent())) {
                $paymentWebHookRequest = json_decode($request->getContent());
                if($paymentWebHookRequest->requestStatusCode == "129"){
                    $responseCode = "";
                } else if($paymentWebHookRequest->requestStatusCode == "176" ) {
                    $responseCode = "188";
                } else if($paymentWebHookRequest->requestStatusCode == "178"){
                    $responseCode = "183";
                } else if($paymentWebHookRequest->requestStatusCode == "179"){
                    $responseCode = "188";
                } else if($paymentWebHookRequest->requestStatusCode == "99"){
                    $responseCode = "188";
                }
                $cellulantResponseRequest = new CellulantResponseRequest();
                $cellulantResponseRequest->checkOutRequestID = $paymentWebHookRequest->checkoutRequestID;
                $cellulantResponseRequest->merchantTransactionID = $paymentWebHookRequest->merchantTransactionID;
                $cellulantResponseRequest->requestStatusCode = $paymentWebHookRequest->requestStatusCode;
                $cellulantResponseRequest->requestStatusDescription = $paymentWebHookRequest->requestStatusDescription;
                $cellulantResponseRequest->MSISDN = $paymentWebHookRequest->MSISDN;
                $cellulantResponseRequest->serviceCode = $paymentWebHookRequest->serviceCode;
                $cellulantResponseRequest->accountNumber = $paymentWebHookRequest->accountNumber;
                $cellulantResponseRequest->currencyCode = $paymentWebHookRequest->currencyCode;
                $cellulantResponseRequest->amountPaid = $paymentWebHookRequest->amountPaid;
                $cellulantResponseRequest->requestCurrencyCode = $paymentWebHookRequest->currencyCode;
                $cellulantResponseRequest->requestAmount = $paymentWebHookRequest->requestAmount;
                $cellulantResponseRequest->requestDate = $paymentWebHookRequest->requestDate;
                $cellulantResponseRequest->payments = json_encode($paymentWebHookRequest->payments);
                $cellulantResponseRequest->save();

                /**
                 * @var DonationRequests $req
                 */
                $req = $cellulantResponseRequest->donationRequest;
                $remaining = $cellulantResponseRequest->amountPaid;
                if ($req->vcrunRegistration) {
                    // Mark reg as paid or record paid amount
                    $vcrunReg = $req->vcrunRegistration;
                    $toPay = min($remaining, $vcrunReg->balance);
                    $vcrunReg->paid_amount += $toPay;
                    if ($vcrunReg->paid_amount >= $vcrunReg->registration_amount) {
                        $vcrunReg->status = 'PAID';
                    }
                    $vcrunReg->save();
                    $remaining -= $toPay;
                }
                // Serve the supports:
                $supports = $req->vcrunSupports;
                foreach ($supports as $support) {
                    /**
                     * @var VcrunSupporter $support
                     */
                    if ($support->balance > 0) {
                        $toPay = min($remaining,$support->balance);
                        $support->paid_amount += $toPay;
                        if ($support->paid_amount >= $support->support_amount) {
                            $support->status = 'PAID';
                        }
                        $support->save();
                        $remaining -= $toPay;
                    }
                }
                $paymentWebHookResponce = new PaymentWebHookResponceBuilder();
                $paymentWebHookResponce->addMerchantTransactionID($paymentWebHookRequest->merchantTransactionID)
                    ->addCheckoutRequestID($paymentWebHookRequest->checkoutRequestID)
                    ->addStatusCode($responseCode)
                    ->addStatusDescription($paymentWebHookRequest->requestStatusDescription)
                    ->addReceiptNumber($paymentWebHookRequest->merchantTransactionID);

                return response()->json($paymentWebHookResponce->getPaymentWebHookResponce(), 200);
            } else {
                $responseCode = "189";
                Log::debug("Request body has no contents");
                $paymentWebHookResponce = new PaymentWebHookResponceBuilder();
                $paymentWebHookResponce->addMerchantTransactionID("1234433434")
                    ->addCheckoutRequestID("383997")
                    ->addStatusCode($responseCode)
                    ->addStatusDescription("Status")
                    ->addReceiptNumber(now());
                // Check if it has registration
                return response()->json($paymentWebHookResponce->getPaymentWebHookResponce(), 200);
            }
        } catch (Exception $e) {
            $responseCode = "189";
            $paymentWebHookResponse = new PaymentWebHookResponceBuilder();
            $paymentWebHookResponse->addMerchantTransactionID("1234433434")
                ->addCheckoutRequestID("383997")
                ->addStatusCode($responseCode)
                ->addStatusDescription("Status")
                ->addReceiptNumber(now());
            return response()->json($paymentWebHookResponse->getPaymentWebHookResponce(), 200);
        }
    }
}
