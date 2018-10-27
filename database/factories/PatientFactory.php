<?php

use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Reception\Models\Patient::class, function (Faker $faker) {
    return [
        'name_kh' => $faker->firstName,
        'name_en' => $faker->lastName,
        'gender' => $faker->randomElement(['M', 'F']),
        'dob' => $faker->dateTimeBetween('-30 years', '-10 years')->format('Y-m-d'),
        'nationality_code' => $faker->countryCode,
        'phone' => $faker->phoneNumber,
        'email' => $faker->safeEmail,
        'address' => $faker->address,
        'identity_type' => $faker->randomElement([1, 2, 3]),
        'identity_no' => random_int(1000000, 2000000),
        'last_visited_at' => Carbon::now(),
        'registered_by' => function() { return factory(User::class)->create()->id; },
    ];
});