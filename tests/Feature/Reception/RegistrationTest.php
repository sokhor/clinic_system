<?php

namespace Tests\Feature\Reception;

use App\Reception\Models\Appointment;
use App\Reception\Models\Patient;
use App\Reception\Models\Queue;
use App\User;
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
    }

    /** @test */
    function it_register_a_patient_and_dont_meet_required_fields()
    {
        $user = factory(User::class)->create();
        $user->allow('create-patients');
        $this->signIn($user);

        $this->postJson('api/reception/register', [])
        ->assertStatus(422)
        ->assertJsonValidationErrors([
            'name_kh',
            'name_en',
            'gender',
            'nationality_code',
            'phone',
            'identity_type',
            'identity_no',
        ]);

        $this->assertCount(0, Patient::all());
        $this->assertCount(0, Queue::all());
    }

    /** @test */
    function it_not_allow_to_register_a_new_patient()
    {
        $this->signIn();

        $patient = factory(Patient::class)->make();
        $queue = factory(Queue::class)->make([
            'patient_id' => null,
            'queue_no' => null
        ]);

        $this->postJson('api/reception/register', array_merge(
            $patient->toArray(),
            $queue->toArray()
        ))->assertStatus(403);

        $this->assertDatabaseMissing('patients', [
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
            'last_visited_at' => $patient->last_visited_at,
            'referal' => $patient->referal,
        ]);

        $this->assertDatabaseMissing('queues', [
            'queue_no' => 1,
            'alive' => true,
        ]);
    }
}
