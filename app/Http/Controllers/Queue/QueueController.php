<?php

namespace App\Http\Controllers\Queue;

use App\Http\Controllers\Controller;
use App\Http\Resources\Queue\QueueResource;
use Domain\Queue\Actions\CreateQueue;
use Domain\Queue\Models\Queue;
use Domain\Queue\ValueObjects\QueueData;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    /**
     * Create a new resource
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Queue::class);

        $this->validate($request, [
            'section_id' => 'required',
        ]);

        $queue = (new CreateQueue)->execute(
            QueueData::fromArray($request->all())
        );

        return new QueueResource($queue);
    }

    /**
     * Get the list of resources
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Queue::class);

        return QueueResource::collection(Queue::with(['section', 'counter'])->today()->get());
    }
}
