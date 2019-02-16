<?php

use Domain\Queue\Models\Queue;
use Domain\Queue\Models\QueueSection;
use Faker\Generator as Faker;

$factory->define(Queue::class, function (Faker $faker) {
    return [
        'ticket' => random_int(100, 300),
        'counter_id' => null,
        'status' => 0,
        'section_id' => factory(QueueSection::class)->create(),
    ];
});
