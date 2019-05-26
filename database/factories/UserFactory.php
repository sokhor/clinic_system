<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'username' => $faker->username,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'active' => true,
        'remember_token' => str_random(10),
        'user_id' => function () {
            return factory(App\User::class)->state('subscriber')->create();
        },
    ];
});

$factory->state(\App\User::class, 'subscriber', function (Faker $faker) {
    return [
        'user_id' => null,
    ];
});
