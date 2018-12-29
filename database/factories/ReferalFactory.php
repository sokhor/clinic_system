<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Referal::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'type' => 'COM',
        'phone' => $faker->phoneNumber,
        'email' => $faker->safeEmail,
    ];
});
