<?php

namespace Tests\Unit\Queue;

use Domain\Queue\Actions\CreateQueue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QueueTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_generate_a_ticket()
    {
        $this->assertEquals('01', (new CreateQueue)->execute()->ticket);
        $this->assertEquals('02', (new CreateQueue)->execute()->ticket);
    }
}
