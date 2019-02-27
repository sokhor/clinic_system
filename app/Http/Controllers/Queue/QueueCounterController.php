<?php

namespace App\Http\Controllers\Queue;

use App\Http\Controllers\Controller;
use App\Http\Resources\Queue\QueueCounterResource;
use Domain\Queue\Actions\CreateQueueCounter;
use Domain\Queue\Models\QueueCounter;
use Domain\Queue\ValueObjects\QueueCounterData;
use Illuminate\Http\Request;

class QueueCounterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $counters = QueueCounter::with('section')->paginate(request()->per_page);

        return QueueCounterResource::collection($counters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $counter = (new CreateQueueCounter)->execute(
            QueueCounterData::fromArray($request->all())
        );

        return new QueueCounterResource($counter);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
