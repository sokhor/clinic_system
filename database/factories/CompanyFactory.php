<?php

use Domain\Administration\Models\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'company_name_kh' => null,
        'company_name_en' => $faker->company,
        'logo' => null,
        'type_of_business' => $faker->randomElement(['Health facility', 'Type 2', 'Type 3']),
        'telephone' => $faker->phoneNumber,
        'mobilephone' => $faker->phoneNumber,
        'email' => $faker->companyEmail,
        'website' => $faker->url,
        'postcode' => $faker->postcode,
        'building' => $faker->buildingNumber,
        'street' => $faker->streetName,
        'village' => $faker->randomElement([1, 2, 3]),
        'commune' => $faker->randomElement([1, 2, 3]),
        'district' => $faker->randomElement([1, 2, 3]),
        'province' => $faker->randomElement(['PNP', 'BAT', 'SPE']),
    ];
});
