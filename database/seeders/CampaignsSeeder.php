<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampaignsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('campaigns')->insert(
            [
                'campaign_name' => 'Student Support',
                'display_narative_box' => false,
            ]);
        DB::table('campaigns')->insert([
            'campaign_name' => 'Elimisha Stratizen',
            'display_narative_box' => false,
        ]);
        DB::table('campaigns')->insert([
            'campaign_name' => 'WASH',
            'display_narative_box' => false,
        ]);
        DB::table('campaigns')->insert([
            'campaign_name' => 'Macheo',
            'display_narative_box' => false,
        ]);
        DB::table('campaigns')->insert([
            'campaign_name' => 'Other',
            'display_narative_box' => true,
        ]);
    }
}
