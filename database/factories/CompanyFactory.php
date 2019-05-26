<?php

use Domain\Administration\Models\Company;
use Faker\Generator as Faker;
use App\User;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create();
        },
        'company_name_kh' => null,
        'company_name_en' => $faker->company,
        'logo' => null,
        'type_of_business' => $faker->randomElement(['Health facility', 'Type 2', 'Type 3']),
        'telephone' => $faker->phoneNumber,
        'mobilephone' => $faker->phoneNumber,
        'email' => $faker->companyEmail,
        'website' => $faker->url,
        'address' => $faker->streetAddress,
        'province' => $faker->randomElement(['PNP', 'BAT', 'SPE']),
        'postcode' => $faker->postcode,
    ];
});
