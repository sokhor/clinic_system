<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\Queue;
use App\Models\Referal;
use App\Models\Staff;
use App\Models\Visit;
use App\Patient\Models\Appointment;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PatientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_register_a_new_patient()
    {
        $user = factory(User::class)->create();
        $user->allow('create-patients');
        $this->signIn($user);

        $patient = factory(Patient::class)->make([
            'dob' => today()->subYears(40)->format(config('app.date_format')),
            'last_visited_at' => now()->format(config('app.timestamp_format')),
        ]);

        $doctor = factory(Staff::class)->create();
        $referal = factory(Referal::class)->create();

        $this->postJson(
            'api/patients',
            collect($patient)
            ->merge([
                'type' => 1, //'Consultation'
                'assigned_id' => $doctor->id,
                'referal_id' => $referal->id,
            ])
            ->toArray()
        )
        ->assertStatus(201);

        $this->assertDatabaseHas('patients', [
            'full_name' => $patient->full_name,
            'full_name_2' => $patient->full_name_2,
            'dob' => Carbon::createFromFormat(config('app.date_format'), $patient->dob)->format('Y-m-d'),
            'gender' => $patient->gender,
            'nationality_code' => $patient->nationality_code,
            'phone' => $patient->phone,
            'email' => $patient->email,
            'address' => $patient->address,
            'identity_type' => $patient->identity_type,
            'identity_no' => $patient->identity_no,
            'photo' => $patient->photo,
        ]);

        $patient = Patient::first();

        $this->assertNotNull($patient->last_visited_at);

        $this->assertDatabaseHas('visits', [
            'patient_id' => $patient->id,
            'ipd' => 0,
            'status' => 0, // Waiting
            'progress' => 1, // Nursing
            'type' => 1, // Consultant
            'assigned_id' => $doctor->id,
            'referal_id' => $referal->id,
            'registered_by' => $user->id,
        ]);
    }

    /** @test */
    public function it_register_a_patient_and_dont_meet_required_fields()
    {
        $user = factory(User::class)->create();
        $user->allow('create-patients');
        $this->signIn($user);

        $this->postJson('api/patients', [])
        ->assertStatus(422)
        ->assertJsonValidationErrors([
            'full_name',
            'gender',
            'nationality_code',
            'phone',
            'identity_type',
            'identity_no',
        ]);

        $this->assertCount(0, Patient::all());
        $this->assertCount(0, Visit::all());
        $this->assertCount(0, Queue::all());
    }

    /** @test */
    public function it_not_allow_to_register_a_new_patient()
    {
        $this->signIn();

        $patient = factory(Patient::class)->make();

        $this->postJson('api/patients', $patient->toArray())
        ->assertStatus(403);

        $this->assertCount(0, Patient::all());
        $this->assertCount(0, Visit::all());
        $this->assertCount(0, Queue::all());
    }

    /** @test */
    public function it_edit_a_patient()
    {
        $user = factory(User::class)->create();
        $user->allow('update-patients');
        $this->signIn($user);

        $patient = factory(Patient::class)->create();

        $this->putJson(
            "api/patients/{$patient->id}",
            array_merge(
                collect($patient)->toArray(),
                [
                'full_name' => 'អ្នកជំងឺ',
                'full_name_2' => 'patient edit',
                'gender' => 'M',
                'nationality_code' => 'KH',
                'phone' => '0987654',
                'identity_type' => 1,
                'identity_no' => '0786545',
            ]
            )
        )
        ->assertStatus(200);

        $this->assertDatabaseHas('patients', [
            'id' => $patient->id,
            'full_name' => 'អ្នកជំងឺ',
            'full_name_2' => 'patient edit',
            'gender' => 'M',
            'nationality_code' => 'KH',
            'phone' => '0987654',
            'identity_type' => 1,
            'identity_no' => '0786545',
        ]);
    }

    /** @test */
    public function it_not_allow_to_edit_a_patient()
    {
        $this->signIn();

        $patient = factory(Patient::class)->create();

        $this->putJson("api/patients/{$patient->id}", array_merge($patient->toArray(), [
            'full_name' => 'អ្នកជំងឺ',
            'full_name_2' => 'patient edit',
            'gender' => 'M',
            'nationality_code' => 'KH',
            'phone' => '0987654',
            'identity_type' => 1,
            'identity_no' => '0786545',
        ]))
        ->assertStatus(403);

        $this->assertDatabaseMissing('patients', [
            'id' => $patient->id,
            'full_name' => 'អ្នកជំងឺ',
            'full_name_2' => 'patient edit',
            'gender' => 'M',
            'nationality_code' => 'KH',
            'phone' => '0987654',
            'identity_type' => 1,
            'identity_no' => '0786545',
        ]);
    }

    /** @test */
    public function it_update_a_patient_and_dont_meet_required_fields()
    {
        $user = factory(User::class)->create();
        $user->allow('update-patients');
        $this->signIn($user);

        $patient = factory(Patient::class)->create();

        $this->putJson("api/patients/{$patient->id}", [])
        ->assertStatus(422)
        ->assertJsonValidationErrors([
            'full_name',
            'gender',
            'nationality_code',
            'phone',
            'identity_type',
            'identity_no',
        ]);

        $this->assertDatabaseHas('patients', collect($patient)->toArray());
    }

    /** @test */
    public function it_fetch_patients()
    {
        $user = factory(User::class)->create();
        $user->allow('view-patients');
        $this->signIn($user);

        factory(Patient::class, 5)->create();

        $this->getJson('api/patients')
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'full_name',
                    'full_name_2',
                    'dob',
                    'gender',
                    'nationality_code',
                    'phone',
                    'email',
                    'address',
                    'identity_type',
                    'identity_no',
                    'last_visited_at',
                    'lastVisit',
                    'age',
                    'identity_type_text',
                ],
            ],
        ]);
    }

    /** @test */
    public function it_not_allow_to_fetch_patients()
    {
        $this->signIn();

        factory(Patient::class, 5)->create();

        $this->getJson('api/patients')
        ->assertStatus(403)
        ->assertJsonMissing(['data']);
    }

    /** @test */
    public function it_show_a_patient()
    {
        $user = factory(User::class)->create();
        $user->allow('view-patients');
        $this->signIn($user);

        $patient = factory(Patient::class)->create();

        $this->getJson("api/patients/{$patient->id}")
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'full_name',
                'full_name_2',
                'dob',
                'gender',
                'nationality_code',
                'phone',
                'email',
                'address',
                'identity_type',
                'identity_no',
                'last_visited_at',
                'lastVisit',
                'age',
                'identity_type_text',
            ],
        ]);
    }

    /** @test */
    public function it_not_allow_to_show_a_patient()
    {
        $this->signIn();

        $patient = factory(Patient::class)->create();

        $this->getJson("api/patients/{$patient->id}")
        ->assertStatus(403)
        ->assertJsonMissing(['data']);
    }

    /** @test */
    public function it_delete_patients()
    {
        $user = factory(User::class)->create();
        $user->allow('delete-patients');
        $this->signIn($user);

        $patient = factory(Patient::class)->create();

        $this->deleteJson("api/patients/{$patient->id}")
        ->assertStatus(200);

        $this->assertDatabaseHas('patients', collect($patient->fresh())->toArray());
        $this->assertNotEquals(null, $patient->fresh()->deleted_at);
    }

    /** @test */
    public function it_not_allow_to_delete_patients()
    {
        $this->signIn();

        $patient = factory(Patient::class)->create();

        $this->deleteJson("api/patients/{$patient->id}")
        ->assertStatus(403);

        $this->assertDatabaseHas('patients', collect($patient)->toArray());
        $this->assertEquals(null, $patient->fresh()->deleted_at);
    }
}
