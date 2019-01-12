<?php

namespace App\Http\Controllers;

use App\Http\Resources\QueueResource;
use App\Models\Queue;
use App\Repositories\QueueRepository;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    /**
     * Queue repository
     *
     * @var \App\Repositories\QueueRepository
     */
    protected $queue;

    /**
     * Create the controller instance
     *
     * @param \App\Repositories\QueueRepository $queue
     */
    public function __construct(QueueRepository $queue)
    {
        $this->queue = $queue;
    }

    /**
     * Create a new resource
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-queues');

        $queue = $this->queue->create();

        return new QueueResource($queue);
    }

    /**
     * Get the list of resources
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view-queues');

        return QueueResource::collection(Queue::today()->get());
    }
}
