<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VcrunSupportersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vcrun_supporters')->insert([
            [
                'id' => 1,
                'supported_registrant_id' => null,
                'request_merchant_id' => '20220429041424',
                'support_amount' => 1000,
                'status' => 'PENDING',
                'paid_amount' => 0,
                'created_at' => '2022-04-29 01:15:00',
                'updated_at' => '2022-04-29 01:15:00'
            ],
            [
                'id' => 2,
                'supported_registrant_id' => 1,
                'request_merchant_id' => '20220429042327',
                'support_amount' => 1000,
                'status' => 'PENDING',
                'paid_amount' => 0,
                'created_at' => '2022-04-29 01:24:17',
                'updated_at' => '2022-04-29 01:24:17'
            ],
            [
                'id' => 3,
                'supported_registrant_id' => null,
                'request_merchant_id' => '20220429042327',
                'support_amount' => 1000,
                'status' => 'PENDING',
                'paid_amount' => 0,
                'created_at' => '2022-04-29 01:24:17',
                'updated_at' => '2022-04-29 01:24:17'
            ],
            [
                'id' => 4,
                'supported_registrant_id' => 1,
                'request_merchant_id' => '20220429043457',
                'support_amount' => 2000,
                'status' => 'PENDING',
                'paid_amount' => 0,
                'created_at' => '2022-04-29 01:35:45',
                'updated_at' => '2022-04-29 01:35:45'
            ],
            [
                'id' => 5,
                'supported_registrant_id' => null,
                'request_merchant_id' => '20220429043457',
                'support_amount' => 1000,
                'status' => 'PENDING',
                'paid_amount' => 0,
                'created_at' => '2022-04-29 01:35:45',
                'updated_at' => '2022-04-29 01:35:45'
            ],
        ]);
    }
}
