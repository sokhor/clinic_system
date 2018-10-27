<?php

use App\Reception\Models\Patient;
use Faker\Generator as Faker;

$factory->define(App\Reception\Models\Queue::class, function (Faker $faker) {
    return [
        'patient_id' => function() { return factory(Patient::class)->create()->id; },
        'queue_no' => random_int(100, 300),
        'alive' => true,
    ];
});
