<?php

use Faker\Generator as Faker;

$factory->define(App\Models\QueueCounter::class, function (Faker $faker) {
    return [
        'label' => $faker->randomNumber(),
        'active' => false,
        'busy' => false,
    ];
});

$factory->state(App\Models\QueueCounter::class, 'inactive', [
    'active' => false,
    'busy' => false,
]);

$factory->state(App\Models\QueueCounter::class, 'busy', [
    'active' => true,
    'busy' => true,
]);

$factory->state(App\Models\QueueCounter::class, 'available', [
    'active' => true,
    'busy' => false,
]);