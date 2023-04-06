<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\VcrunRegistrationsTableSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VcrunRegistrationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            DB::table('vcrun_registrations')->insert([
                [
                    'id' => 1,
                    'request_merchant_id' => '20220505123555',
                    'participation_type' => 'PHYSICAL',
                    'race_kms' => 18,
                    'registration_amount' => 1000,
                    'status' => 'PAID',
                    'matching_donor_id' => null,
                    'matched_amount' => null,
                    'created_at' => '2022-04-28 21:15:58',
                    'updated_at' => '2022-04-28 21:15:58',
                    'paid_amount' => 0,
                ],
                [
                    'id' => 2,
                    'request_merchant_id' => '20220429044914',
                    'participation_type' => 'PHYSICAL',
                    'race_kms' => 5,
                    'registration_amount' => 5,
                    'status' => 'PENDING',
                    'matching_donor_id' => null,
                    'matched_amount' => 5,
                    'created_at' => '2022-04-29 01:50:04',
                    'updated_at' => '2022-04-29 01:50:58',
                    'paid_amount' => 5,
                ],
                [
                    'id' => 3,
                    'request_merchant_id' => '20220429102458',
                    'participation_type' => 'PHYSICAL',
                    'race_kms' => 5,
                    'registration_amount' => 1000,
                    'status' => 'PENDING',
                    'matching_donor_id' => null,
                    'matched_amount' => 1000,
                    'created_at' => '2022-04-29 07:26:12',
                    'updated_at' => '2022-04-29 07:26:12',
                    'paid_amount' => 0,
                ],
                [
                    'id' => 5,
                    'request_merchant_id' => '20220504094902',
                    'participation_type' => 'PHYSICAL',
                    'race_kms' => 5,
                    'registration_amount' => 1000,
                    'status' => 'PENDING',
                    'matching_donor_id' => null,
                    'matched_amount' => 1000,
                    'created_at' => '2022-05-04 06:51:42',
                    'updated_at' => '2022-05-04 06:51:42',
                    'paid_amount' => 0,
                ],
            ]);
        }
}
