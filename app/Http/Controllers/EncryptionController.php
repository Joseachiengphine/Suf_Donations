<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\CustomClass\Checkout;

class EncryptionController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function __invoke(Request $request, $donationCode)
    {
        if(!is_null($donationCode)) {
            if(Donation::where('donation_code', $donationCode)->count() > 0) {
                $donationsConfigs = Donation::where('donation_code', $donationCode)->first();
                $checkoutRequestBody = $request->getContent();
                $checkoutPayload = json_decode($checkoutRequestBody);
                $checkout = new Checkout($donationsConfigs->secret_key, $donationsConfigs->init_vector);
                $params = $checkout->encrypt($checkoutPayload->body);
                $den = $checkout->decrypt($params);
                return response()->json(array("params" => $params), 200);
            }
        }
        return response()->json(array("params" => "Invalid"),401);
    }
}
