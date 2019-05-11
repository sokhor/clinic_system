<?php

use App\Models\Patient;
use App\Models\Staff;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(App\Models\Appointment::class, function (Faker $faker) {
    return [
        'patient_id' => function () {
            return factory(Patient::class)->create()->id;
        },
        'subject' => $faker->sentence,
        'appointed_at' => Carbon::now()->addDay(random_int(3, 30))->format('Y-m-d H:i:s'),
        'comment' => $faker->paragraph,
        'doctor_id' => function () {
            return factory(Staff::class)->states('doctor')->create()->id;
        },
        'status' => $faker->randomElement([0, 1]),
    ];
});
