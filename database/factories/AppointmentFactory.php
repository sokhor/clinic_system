<?php

use App\Reception\Models\Patient;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(App\Reception\Models\Appointment::class, function (Faker $faker) {
    return [
        'patient_id' => function() { return factory(Patient::class)->create()->id; },
        'next_visit_at' => Carbon::now()->addDay(random_int(3, 30)),
        'referal' => $faker->company,
        'refer_to' => null,
        'type' => $faker->randomElement([1, 2]),
        'status' => $faker->randomElement([1, 2]),
    ];
});
