<?php

namespace Tests\Unit;

use App\Repositories\QueueRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QueueTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_generate_a_ticket()
    {
        $repository = new QueueRepository;

        $this->assertEquals('01', $repository->create()->ticket);
        $this->assertEquals('02', $repository->create()->ticket);
    }
}
