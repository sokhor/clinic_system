<?php

namespace App\Http\Controllers\Queue;

use App\Http\Controllers\Controller;
use App\Http\Resources\Queue\QueueSectionResource;
use Domain\Queue\Actions\CreateQueueSection;
use Domain\Queue\Models\QueueSection;
use Domain\Queue\ValueObjects\QueueSectionData;
use Illuminate\Http\Request;

class QueueSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $section = QueueSection::with('counters')->get();

        return QueueSectionResource::collection($section);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $queue_section = (new CreateQueueSection)->execute(
            QueueSectionData::fromArray($request->all())
        );

        return (new QueueSectionResource($queue_section))
            ->additional(['message' => 'Section created']);
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
