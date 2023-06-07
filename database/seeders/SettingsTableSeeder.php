<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            'Current Matching Donor' => null,
            'Registration Amount' => 1000,
            'Matching Percentage' => 100,
            'Checkout Type' => 'modal' // modal or redirect
        ];
        foreach ($settings as $setting => $payload) {
            $setting = \App\Models\Setting::query()->firstOrCreate(['name' => $setting],[
                'name' => $setting,
                'slug' => \Illuminate\Support\Str::slug($setting),
                'payload' => $payload,
            ]);
        }
    }
}
