<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_make_an_appointment()
    {$this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $user->allow('create-appointments');
        $this->signIn($user);

        $appointment = factory(Appointment::class)->make();

        $this->postJson('api/appointments', array_merge(
            collect($appointment)->except('status')->toArray(), [
            'appointed_at' => Carbon::createFromFormat('Y-m-d H:i:s', $appointment->appointed_at)->format('d-m-Y H:i:s'),
        ]))->assertStatus(201);

        $this->assertDatabaseHas('appointments', [
            'patient_id' => $appointment->patient_id,
            'subject' => $appointment->subject,
            'appointed_at' => $appointment->appointed_at,
            'comment' => $appointment->comment,
            'doctor_id' => $appointment->doctor_id,
            'status' => 0,
        ]);
    }

    /** @test */
    function it_not_allow_to_make_an_appointment()
    {
        $this->signIn();

        $appointment = factory(Appointment::class)->make();

        $this->postJson('api/appointments', $appointment->toArray())
            ->assertStatus(403);

        $this->assertCount(0, Appointment::all());
    }

    /** @test */
    function it_edit_an_appointment()
    {
        $user = factory(User::class)->create();
        $user->allow('update-appointments');
        $this->signIn($user);

        $appointment = factory(Appointment::class)->create();

        $this->putJson("api/appointments/{$appointment->id}", array_merge($appointment->toArray(), [
            'subject' => 'Diagnose retreat',
            'appointed_at' => Carbon::createFromFormat('Y-m-d H:i:s', $appointment->appointed_at)->format('d-m-Y H:i:s'),
        ]))->assertStatus(200);

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'patient_id' => $appointment->patient_id,
            'subject' => 'Diagnose retreat',
            'appointed_at' => $appointment->appointed_at,
            'comment' => $appointment->comment,
            'doctor_id' => $appointment->doctor_id,
            'status' => $appointment->status,
        ]);
    }

    /** @test */
    function it_not_allow_to_edit_appointment()
    {
        $this->signIn();

        $appointment = factory(Appointment::class)->create();

        $this->putJson("api/appointments/{$appointment->id}", array_merge($appointment->toArray(), [
            'subject' => 'Diagnose retreat',
            'appointed_at' => Carbon::createFromFormat('Y-m-d H:i:s', $appointment->appointed_at)->format('d-m-Y H:i:s'),
        ]))->assertStatus(403);

        $this->assertDatabaseMissing('appointments', [
            'id' => $appointment->id,
            'patient_id' => $appointment->patient_id,
            'subject' => 'Diagnose retreat',
            'appointed_at' => $appointment->appointed_at,
            'comment' => $appointment->comment,
            'doctor_id' => $appointment->doctor_id,
            'status' => $appointment->status,
        ]);
    }

    /** @test */
    function it_delete_an_appointment()
    {
        $user = factory(User::class)->create();
        $user->allow('delete-appointments');
        $this->signIn($user);

        $appointment = factory(Appointment::class)->create();

        $this->assertCount(1, Appointment::all());

        $this->deleteJson("api/appointments/{$appointment->id}")->assertStatus(200);

        $this->assertCount(0, Appointment::all());
    }

    /** @test */
    function it_not_allow_to_delete_an_appointment()
    {
        $this->signIn();

        $appointment = factory(Appointment::class)->create();

        $this->assertCount(1, Appointment::all());

        $this->deleteJson("api/appointments/{$appointment->id}")->assertStatus(403);

        $this->assertCount(1, Appointment::all());
    }

    /** @test */
    function it_fetch_appointments()
    {
        $user = factory(User::class)->create();
        $user->allow('view-appointments');
        $this->signIn($user);

        $appointment = factory(Appointment::class, 10)->create();

        $this->getJson("api/appointments")
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'patient_id',
                    'subject',
                    'appointed_at',
                    'comment',
                    'doctor_id',
                    'status',
                ],
            ],
        ]);
    }

    /** @test */
    function it_not_allow_to_fetch_appointments()
    {
        $this->signIn();

        $appointment = factory(Appointment::class, 10)->create();

        $this->getJson("api/appointments")
        ->assertStatus(403)
        ->assertJsonMissing(['data']);
    }
}
