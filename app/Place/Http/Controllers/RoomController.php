<?php

namespace App\Place\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Place\Http\Requests\RoomCreateRequest;
use App\Place\Http\Requests\RoomDeleteRequest;
use App\Place\Http\Requests\RoomUpdateRequest;
use App\Place\Http\Requests\RoomViewRequest;
use App\Place\Http\Resources\RoomResource;
use App\Place\Models\Room;

class RoomController extends Controller
{
    /**
     * Get rooms.
     *
     * @param  \App\Http\Requests\RoomViewRequest $request     *
     * @return \Illuminate\Http\Response
     */
    public function index(RoomViewRequest $request)
    {
        return RoomResource::collection(
            Room::with(['building', 'ward'])->paginate($request->per_page)
        );
    }

    /**
     * Show a room.
     *
     * @param  \App\Http\Requests\RoomViewRequest $request
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function show(RoomViewRequest $request, $id)
    {
        $room = Room::with(['building', 'ward'])->findOrFail($id);

        return new RoomResource($room);
    }

    /**
     * Create a room.
     *
     * @param  \App\Http\Requests\RoomCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomCreateRequest $request)
    {
        return new RoomResource(Room::create($request->all()));
    }

    /**
     * Update a room.
     *
     * @param  \App\Http\Requests\RoomUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(RoomUpdateRequest $request, Room $room)
    {
        $room->update($request->all());

        return new RoomResource($room->fresh());
    }

    /**
     * Delete a room.
     *
     * @param  \App\Http\Requests\RoomDeleteRequest $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoomDeleteRequest $request, Room $room)
    {
        $room->delete();

        return new RoomResource($room);
    }
}
