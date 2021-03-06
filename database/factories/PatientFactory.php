<?php

use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Models\Patient::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name,
        'full_name_2' => null,
        'gender' => $faker->randomElement(['M', 'F']),
        'dob' => $faker->dateTimeBetween('-30 years', '-10 years')->format('Y-m-d'),
        'nationality_code' => $faker->countryCode,
        'phone' => $faker->phoneNumber,
        'email' => $faker->safeEmail,
        'address' => $faker->address,
        'identity_type' => $faker->randomElement([1, 2, 3]),
        'identity_no' => random_int(1000000, 2000000),
        'photo' => null,
        'last_visited_at' => Carbon::now()->format('Y-m-d H:i:s'),
    ];
});
