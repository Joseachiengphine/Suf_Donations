<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VcRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\App\Models\VcrunRegistration::query()->where("request_merchant_id","=","VC")->exists()) {
            return;
        }
        $reg = new \App\Models\VcrunRegistration();
        // TODO: Change this merchant id to a real one.
        $reg->request_merchant_id = 'VC';
        $reg->participation_type = 'PHYSICAL';
        $reg->race_kms = 18;
        $reg->registration_amount = 1000;
        $reg->status = 'PAID';
        $reg->saveOrFail();
    }
}
