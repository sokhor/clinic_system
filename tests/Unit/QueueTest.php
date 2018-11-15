<?php

namespace Tests\Unit;

use App\Patient\Models\Patient;
use App\Patient\Models\Queue;
use Facades\App\Patient\Repositories\QueueRepositroy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QueueTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function start_the_queue_of_the_day_to_number_1_then_increment()
    {
        // Yesterday queue
        factory(Queue::class, 100)->create([
            'queue_no' => random_int(100, 300),
            'created_at' => today()->subDay()
        ]);

        // Today queue
        $patient = factory(Patient::class)->create();
        $queue = QueueRepositroy::generate($patient);
        $this->assertEquals(1, $queue->queue_no);

        $patient = factory(Patient::class)->create();
        $queue = QueueRepositroy::generate($patient);
        $this->assertEquals(2, $queue->queue_no);
    }
}
