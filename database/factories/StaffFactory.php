<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Staff::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name,
        'full_name_2' => null,
        'gender' => $faker->randomElement(['M', 'F']),
        'position_id' => function() { return factory(App\Models\Position::class)->create()->id; },
        'phone' => $faker->phoneNumber,
        'email' => $faker->safeEmail,
        'start_work_date' => today()->format('Y-m-d'),
    ];
});
