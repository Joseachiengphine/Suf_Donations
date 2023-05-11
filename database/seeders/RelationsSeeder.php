<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('relations')->insert(
            [
                'relation_name' => 'Alumni',
                'display_graduation_yr' => true,
            ]);
        DB::table('relations')->insert([
            'relation_name' => 'Staff',
            'display_graduation_yr' => false,
        ]);
        DB::table('relations')->insert([
            'relation_name' => 'Student',
            'display_graduation_yr' => false,
        ]);
        DB::table('relations')->insert([
            'relation_name' => 'Friend / Partner',
            'display_graduation_yr' => false,
        ]);
        DB::table('relations')->insert([
            'relation_name' => 'Other',
            'display_graduation_yr' => false,
        ]);
    }
}
