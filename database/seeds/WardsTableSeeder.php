<?php

use Illuminate\Database\Seeder;
use App\Place\Models\Ward;

class WardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ward::truncate();

        factory(Ward::class)->create([
            'name_kh' => 'ផ្នែកសម្ភារៈនិងបរិក្ខាពេទ្យ',
            'name_en' => 'Instruments and materials',
        ]);

        factory(Ward::class)->create([
            'name_kh' => 'ផ្នែកថ្នាំបង្ការ',
            'name_en' => 'Vaccination',
        ]);

        factory(Ward::class)->create([
            'name_kh' => 'ធនធានមនុស្ស',
            'name_en' => 'Human resource',
        ]);

        factory(Ward::class)->create([
            'name_kh' => 'ផ្នែកទទួលភ្ុំៀវ និង កាន់កាប់លុយ',
            'name_en' => 'Receiption and accountant',
        ]);
    }
}
