<?php

use App\Patient\Models\Patient;
use Faker\Generator as Faker;

$factory->define(App\Patient\Models\Queue::class, function (Faker $faker) {
    return [
        'patient_id' => function() { return factory(Patient::class)->create()->id; },
        'queue_no' => random_int(100, 300),
        'previous_by' => null,
        'next_by' => null,
        'status' => null,
    ];
});
