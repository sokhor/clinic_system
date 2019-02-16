<?php

use Domain\Queue\Models\QueueSection;
use Faker\Generator as Faker;

$factory->define(QueueSection::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['Doctor Consulting', 'Laboratory', 'Physic']),
        'active' => false,
    ];
});
