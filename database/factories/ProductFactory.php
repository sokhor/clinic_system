<?php

use App\Domain\Inventory\Entities\ProductCategory;
use App\Domain\Inventory\Entities\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'product_name' => $faker->randomElement(['Dafalgan', 'Doliprance', 'Imoryl Diarrhee']),
        'product_code' => $faker->unique()->randomNumber(),
        'brand_name' => $faker->randomElement(['Disuf', 'Para', 'Azi', 'Amox', 'Smecta']),
        'category_id' => factory(ProductCategory::class)->create(),
        'made_in' => $faker->country,
        'compositions' => json_encode($faker->randomElements(['Fucidic Acid', 'Acetaminophen', 'Azithromycin', 'Amocicillin'], 2)),
        'laboratory' => $faker->randomElement(['PPM', 'Roch', 'Glaxo', 'Smithcline']),
    ];
});
