<?php

use Faker\Generator as Faker;
use Domain\HumanResource\Models\EmployeePosition;

$factory->define(EmployeePosition::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['Nurse', 'Doctor', 'Midwife', 'Cashier', 'Pharmacist']),
        'order' => null,
    ];
});
