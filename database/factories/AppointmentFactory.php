<?php

use App\Reception\Models\Patient;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(App\Reception\Models\Appointment::class, function (Faker $faker) {
    return [
        'patient_id' => function() { return factory(Patient::class)->create()->id; },
        'visit_at' => Carbon::now(),
        'referal' => $faker->company,
        'refer_to' => null,
        'type' => $faker->randomElement([1, 2]),
        'status' => $faker->randomElement([1, 2]),
        'created_by' => function() { return factory(User::class)->create()->id; },
    ];
});
