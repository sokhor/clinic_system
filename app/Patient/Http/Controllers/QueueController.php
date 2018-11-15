<?php

namespace App\Patient\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Patient\Http\Resources\QueueResource;
use App\Patient\Models\Queue;
use App\Patient\Repositories\QueueRepositroy;

class QueueController extends Controller
{
    /**
     * Queue repository
     *
     * @var \App\Patient\Repositories\QueueRepositroy
     */
    protected $queue;

    /**
     * Create the controller instance
     *
     * @param \App\Patient\Repositories\QueueRepositroy $queue
     */
    public function __construct(QueueRepositroy $queue)
    {
        $this->queue = $queue;
    }

    /**
     * Get patients
     *
     * @param  \App\Place\Http\Requests\PatientViewRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return QueueResource::collection(
            Queue::with('patient')
                ->whereDate('created_at', today())
                ->latest()
                ->paginate()
        );
    }
}
