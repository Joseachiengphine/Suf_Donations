<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddVcRunDonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $donation = \App\Models\Donation::query()->where('donation_code', '=', 'VCRUN')->firstOr(function () {
            $donation = new \App\Models\Donation();
            $donation->donation_code = 'VCRUN';
            $donation->donation_description = "Donations for Vice Chancellor's run";
            $donation->service_code = "STRATHMORE";
            $donation->country_code = 'KE';
            $donation->lang = 'en';
            $donation->success_redirect_url = config('vcrun.success_callback', '/');
            $donation->fail_redirect_url = config('vcrun.failed_callback', '');
            $donation->payment_web_hook = config('vcrun.payment_webhook', 'https://apps.strathmore.edu/suf-donations/api/vcrun-webhook-response');
            $donation->page_title = "Strathmore University Vice Chancellor's Run";
            $donation->access_key = config('vcrun.access_key', 'sandbox');
            $donation->account_nbr = config('vcrun.account_nbr', 10092020);
            $donation->secret_key = config('vcrun.secret_key', 'sandbox');
            $donation->init_vector = config('vcrun.init_vector', '10092020');
            $donation->checkout_url = config('vcrun.checkout_url', 'https://online.tingg.africa/v2/tingg-checkout.js');
            $donation->default_campaign = \App\Models\Campaign::VC_RUN;
            $donation->default_relation = config('vcrun.default_relation', '');
            $donation->save();
        });
    }
}
