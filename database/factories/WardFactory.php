<?php

use Faker\Generator as Faker;

$factory->define(App\Place\Ward::class::class, function (Faker $faker) {
    return [
        'name_kh' => $faker->name,
        'name_en' => $faker->name,
    ];
});
