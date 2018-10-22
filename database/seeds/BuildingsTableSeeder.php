<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Place\Models\Building;

class BuildingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('building_ward')->truncate();
        Building::truncate();

        factory(Building::class)->create([
            'name_kh' => 'អគារ៤អា',
            'name_en' => 'House 4A',
            'code' => '4A',
        ]);

        factory(Building::class)->create([
            'name_kh' => 'អគារ២អា',
            'name_en' => 'House 2A',
            'code' => '2A',
        ]);
    }
}
