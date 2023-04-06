<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\DonationsTableSeeder;
use Database\Seeders\VcrunRegistrationsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(DonationsTableSeeder::class);
        $this->call(VcrunRegistrationsTableSeeder::class);
        $this->call(VcrunSupportersTableSeeder::class);

    }
}
