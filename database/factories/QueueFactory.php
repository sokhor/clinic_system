<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Queue::class, function (Faker $faker) {
    return [
        'patient_id' => null,
        'visit_id' => null,
        'ticket' => random_int(100, 300),
        'counter_id' => null,
        'status' => 0,
    ];
});
