<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AppointmentController extends Controller
{
    /**
     * Create a new resource
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-appointments');

        $request->validate([
            'patient_id' => 'required',
            'subject' => 'required',
            'appointed_at' => 'required',
            'doctor_id' => 'required',
        ]);

        $appointment = Appointment::create(array_merge($request->all(), [
            'appointed_at' => Carbon::createFromFormat(config('app.timestamp_format'), $request->appointed_at)->format('Y-m-d H:i:s'),
        ]));

        return new AppointmentResource($appointment);
    }

    /**
     * Update a resource
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        $this->authorize('update-appointments');

        $request->validate([
            'patient_id' => 'required',
            'subject' => 'required',
            'appointed_at' => 'required',
            'doctor_id' => 'required',
        ]);

        $appointment->update(array_merge($request->all(), [
            'appointed_at' => Carbon::createFromFormat(config('app.timestamp_format'), $request->appointed_at)->format('Y-m-d H:i:s'),
        ]));

        return new AppointmentResource($appointment->fresh());
    }

    /**
     * Destroy an appointment
     *
     * @param  App\Models\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete-appointments');

        return new AppointmentResource(tap($appointment)->delete());
    }

    public function index()
    {
        $this->authorize('view-appointments');

        return AppointmentResource::collection(
            Appointment::paginate(request()->per_page ?? 15)
        );
    }
}
