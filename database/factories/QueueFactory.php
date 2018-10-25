<?php

use App\Reception\Models\Appointment;
use Faker\Generator as Faker;

$factory->define(App\Reception\Models\Queue::class, function (Faker $faker) {
    return [
        'appointment_id' => function() { return factory(Appointment::class)->create()->id; },
        'queue_no' => random_int(100, 300),
        'alive' => true,
    ];
});
