<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('villages')->truncate();
        DB::table('communes')->truncate();
        DB::table('districts')->truncate();
        DB::table('provinces')->truncate();

        DB::table('provinces')->insert([
            ['province_code' => 'PNP', 'province_en' => 'Phnom Penh', 'province_kh' => 'ភ្នំពេញ'],
            ['province_code' => 'BAT', 'province_en' => 'Battambong', 'province_kh' => 'បាត់ដំបង'],
            ['province_code' => 'SPE', 'province_en' => 'Kampong Speu', 'province_kh' => 'កំពង់ស្ពឺ'],
        ]);

        DB::table('districts')->insert([
            ['province_code' => 'PNP', 'district_en' => 'Chamkarmorn', 'district_kh' => 'ចំការមន'],
            ['province_code' => 'PNP', 'district_en' => 'Tuolkork', 'district_kh' => 'ទួលគោក'],
            ['province_code' => 'PNP', 'district_en' => 'Dongkor', 'district_kh' => 'ដង្កោ'],
        ]);

        DB::table('communes')->insert([
            ['province_code' => 'PNP', 'district_id' => 1, 'commune_en' => 'Tonle Basac', 'commune_kh' => 'ទន្លេបាសាក់'],
            ['province_code' => 'PNP', 'district_id' => 1, 'commune_en' => 'Tuoltumpoung', 'commune_kh' => 'ទួលទំពូង'],
            ['province_code' => 'PNP', 'district_id' => 1, 'commune_en' => 'Boeng Trabek', 'commune_kh' => 'បឹងត្របែក'],
        ]);

        DB::table('villages')->insert([
            ['province_code' => 'PNP', 'district_id' => 1, 'commune_id' => 1, 'village_en' => 'Phum 1', 'village_kh' => 'ភូមិ ១'],
            ['province_code' => 'PNP', 'district_id' => 1, 'commune_id' => 1, 'village_en' => 'Phum 2', 'village_kh' => 'ភូមិ ២'],
            ['province_code' => 'PNP', 'district_id' => 1, 'commune_id' => 1, 'village_en' => 'Phum 3', 'village_kh' => 'ភូមិ ៣'],
        ]);
    }
}
