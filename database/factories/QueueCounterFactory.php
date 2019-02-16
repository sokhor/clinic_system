<?php

use Domain\Queue\Models\QueueCounter;
use Domain\Queue\Models\QueueSection;
use Faker\Generator as Faker;

$factory->define(QueueCounter::class, function (Faker $faker) {
    return [
        'label' => $faker->randomNumber(),
        'active' => false,
        'busy' => false,
        'section_id' => factory(QueueSection::class)->create(),
    ];
});

$factory->state(QueueCounter::class, 'inactive', [
    'active' => false,
    'busy' => false,
]);

$factory->state(QueueCounter::class, 'busy', [
    'active' => true,
    'busy' => true,
]);

$factory->state(QueueCounter::class, 'available', [
    'active' => true,
    'busy' => false,
]);