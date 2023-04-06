<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DonationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('donations')->insert([
            [
                'donation_code' => 'DEFAULT',
                'donation_description' => 'All donations',
                'service_code' => 'STRATHMORE',
                'country_code' => 'KE',
                'lang' => 'en',
                'success_redirect_url' => 'https://foundation.strathmore.edu/donation-submitted/',
                'fail_redirect_url' => 'https://foundation.strathmore.edu/donation-failed/',
                'payment_web_hook' => 'https://apps.strathmore.edu/suf-donations/api/paymentWebHookResponse',
                'due_date_duration_in_hours' => 0,
                'page_title' => 'Strathmore University Foundation',
                'access_key' => 'adSbQRGAa2gtJF2gN8NZqGJKjSs6sDaUHkfUKzYmSA5DXejb7E2EfnUPAsdHz',
                'account_nbr' => '10092020',
                'secret_key' => '8WMbwxq4KxXgxEx',
                'init_vector' => '',
                'checkout_url' => 'https://online.tingg.africa/v2/tingg-checkout.js',
            ],
            [
                'donation_code' => 'VCRUN',
                'donation_description' => "Donations for Vice Chancellor's run",
                'service_code' => 'STRATHMORE',
                'country_code' => 'KE',
                'lang' => 'en',
                'success_redirect_url' => 'https://vcrun.strathmore.edu',
                'fail_redirect_url' => 'https://vcrun.strathmore.edu/register',
                'payment_web_hook' => 'https://apps.strathmore.edu/suf-donations/api/vcrun-webhook-response',
                'due_date_duration_in_hours' => 0,
                'page_title' => "Strathmore University Vice Chancellor's Run",
                'access_key' => 'adSbQRGAa2gtJF2gN8NZqGJKjSs6sDaUHkfUKzYmSA5DXejb7E2EfnUPAsdHz',
                'account_nbr' => '10092020',
                'secret_key' => '8WMbwxq4KxXgxEx',
                'init_vector' => '',
                'checkout_url' => 'https://online.tingg.africa/v2/tingg-checkout.js',
            ],
        ]);
    }
}




