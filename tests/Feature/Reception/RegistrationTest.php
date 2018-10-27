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
        $user = factory(User::class)->create();
        $user->allow('create-patients');
        $this->signIn($user);

        $patient = factory(Patient::class)->make();

        $this->postJson('api/patient', $patient->toArray())
        ->assertStatus(201);

        $this->assertDatabaseHas('patients', [
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
            'registered_by' => $user->id,
        ]);

        $patient = Patient::first();

        $this->assertDatabaseHas('queues', [
            'patient_id' => $patient->id,
            'queue_no' => 1,
            'alive' => true,
        ]);
    }

    /** @test */
    function it_register_a_patient_and_dont_meet_required_fields()
    {
        $user = factory(User::class)->create();
        $user->allow('create-patients');
        $this->signIn($user);

        $this->postJson('api/patient', [])
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

        $this->postJson('api/patient', $patient->toArray())
        ->assertStatus(403);

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
