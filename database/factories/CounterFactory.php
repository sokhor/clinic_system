<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Counter::class, function (Faker $faker) {
    return [
        'label' => $faker->randomNumber(),
        'disabled' => false,
        'available' => true,
    ];
});
