<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Position::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['Nurse', 'Doctor', 'Midwife', 'Cashier', 'Pharmacist']),
        'order' => null,
    ];
});
