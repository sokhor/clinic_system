<?php

use Faker\Generator as Faker;

$factory->define(App\Place\Models\Building::class, function (Faker $faker) {
    return [
        'name_kh' => $faker->name,
        'name_en' => $faker->name,
        'code' => strtoupper(str_random(4)),
    ];
});
