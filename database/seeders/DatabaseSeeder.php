<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
//            CampaignsSeeder::class,
//            RelationsSeeder::class,
            AddVcRunDonationSeeder::class,
            VcRegistrationSeeder::class,
            SettingsTableSeeder::class,
        ]);
    }
}
