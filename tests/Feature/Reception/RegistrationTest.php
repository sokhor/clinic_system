<?php

namespace Tests\Feature\Reception;

use App\Reception\Models\Appointment;
use App\Reception\Models\Patient;
use App\Reception\Models\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_register_a_new_patient()
    {
        $this->signIn();

        $patient = factory(Patient::class)->make();
        $appointment = factory(Appointment::class)->make(['patient_id' => null]);
        $queue = factory(Queue::class)->make(['appointment_id' => null]);

        $this->postJson('api/reception/register', array_merge(
            $patient->toArray(),
            $appointment->toArray(),
            $queue->toArray()
        ))->assertStatus(201);

        $this->assertDatabaseHas('patients', [
            'code' => $patient->code,
            'name_kh' => $patient->name_kh,
            'name_en' => $patient->name_en,
            'dob' => $patient->dob,
            'gender' => $patient->gender,
            'nationality_code' => $patient->nationality_code,
            'phone' => $patient->phone,
            'email' => $patient->email,
            'address' => $patient->address,
            'identity_type' => $patient->identity_type,
            'identity_no' => $patient->identity_no,
        ]);

        $patient = Patient::first();

        $this->assertDatabaseHas('appointments', [
            'patient_id' => $patient->id,
            'visit_at' => $appointment->visit_at,
            'referal' => $appointment->referal,
            'refer_to' => $appointment->refer_to,
            'type' => $appointment->type,
            'status' => $appointment->status,
        ]);

        $appointment = Appointment::first();

        $this->assertDatabaseHas('queues', [
            'appointment_id' => $appointment->id,
            'queue_no' => $queue->queue_no,
            'alive' => $queue->alive,
        ]);
    }
}
