<?php

use App\Place\Models\Building;
use App\Place\Models\Ward;
use Faker\Generator as Faker;

$factory->define(App\Place\Models\Room::class, function (Faker $faker) {
    $room_number = random_int(1, 100);

    return [
        'building_id' => function() { return factory(Building::class)->create()->id; },
        'ward_id' => function() { return factory(Ward::class)->create()->id; },
        'name_kh' => 'Room ' . $room_number,
        'name_en' => 'បន្ទប់ ' . $room_number,
        'code' => 'ROOM-' . $room_number,
        'price' => random_int(30, 300),
        'floor' => $faker->randomNumber([0, 1, 2, 3]),
        'status' => $faker->randomNumber([1, 2, 3]),
    ];
});
