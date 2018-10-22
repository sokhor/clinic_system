<?php

use App\Place\Models\Room;
use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Room::truncate();

        factory(Room::class)->create([
            'building_id' => 1,
            'ward_id' => 1,
            'name_kh' => 'បន្ទប់ទី១',
            'name_en' => 'Room 1',
            'code' => 'ROOM-1',
            'price' => 20,
            'floor' => 1,
            'status' => 1,
        ]);

        factory(Room::class)->create([
            'building_id' => 1,
            'ward_id' => 1,
            'name_kh' => 'បន្ទប់ទី២',
            'name_en' => 'Room 2',
            'code' => 'ROOM-2',
            'price' => 30,
            'floor' => 1,
            'status' => 2,
        ]);

        factory(Room::class)->create([
            'building_id' => 1,
            'ward_id' => 1,
            'name_kh' => 'បន្ទប់ទី៣',
            'name_en' => 'Room 3',
            'code' => 'ROOM-3',
            'price' => 40,
            'floor' => 1,
            'status' => 3,
        ]);
    }
}
