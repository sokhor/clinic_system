<?php

use Faker\Generator as Faker;
use Domain\HumanResource\Models\Employee;
use Illuminate\Support\Carbon;
use Domain\HumanResource\Models\EmployeePosition;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'name_native' => $faker->randomElement(['នីតា', 'បូណា', 'សុខន']),
        'name_latin' => $faker->name,
        'born' => Carbon::today()->subYears($faker->numberBetween(20, 50)),
        'gender' => $faker->randomElement(['Male', 'Female']),
        'marital' => $faker->randomElement(['Single', 'Married']),
        'emp_no' => $faker->numberBetween(10000, 50000),
        'address' => [
            'house' => $faker->buildingNumber,
            'street' => $faker->streetName,
            'village' =>'Tonle Basac',
            'district' => 'Chamkarmorn',
            'city_province' => $faker->city,
        ],
        'position_id' => function () {
            return factory(EmployeePosition::class)->create()->id;
        },
        'id_card_type' => $faker->randomElement(['National ID', 'Passport', 'Driving License']),
        'id_card_no' => $faker->randomNumber(5),
        'hiring_date' => Carbon::today()->subMonths($faker->numberBetween(1, 50)),
        'hiring_status' => $faker->randomElement(['Active', 'Resigned']),
    ];
});
