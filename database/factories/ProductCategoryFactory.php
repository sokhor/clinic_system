<?php

use App\Domain\Inventory\Entities\ProductCategory;
use Faker\Generator as Faker;

$factory->define(ProductCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['Antibiotic', 'Gastro-enterology']),
    ];
});
