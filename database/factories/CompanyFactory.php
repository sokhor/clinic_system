<?php

use Domain\Administration\Models\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'comany_name_kh' => null,
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
        'village' => $faker->randomElement(['Phuom 1', 'Phuom 2', 'Phuom 3']),
        'commune' => $faker->randomElement(['Commune 1', 'Commune 2', 'Commune 3']),
        'district' => $faker->randomElement(['District 1', 'District 2', 'District 3']),
        'province' => $faker->city,
    ];
});
