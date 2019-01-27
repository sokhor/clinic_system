<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Counter::class, function (Faker $faker) {
    return [
        'label' => $faker->randomNumber(),
        'active' => false,
        'busy' => false,
    ];
});

$factory->state(App\Models\Counter::class, 'inactive', [
    'active' => false,
    'busy' => false,
]);

$factory->state(App\Models\Counter::class, 'busy', [
    'active' => true,
    'busy' => true,
]);

$factory->state(App\Models\Counter::class, 'available', [
    'active' => true,
    'busy' => false,
]);