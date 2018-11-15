<?php

namespace Tests\Feature;

use App\Patient\Models\Appointment;
use App\Patient\Models\Patient;
use App\Patient\Models\Queue;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PatientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_register_a_new_patient()
    {
        $user = factory(User::class)->create();
        $user->allow('create-patients');
        $this->signIn($user);

        $patient = factory(Patient::class)->make();

        $this->postJson('api/patients', $patient->toArray())
        ->assertStatus(201);

        $this->assertDatabaseHas('patients', [
            'full_name' => $patient->full_name,
            'full_name_optional' => $patient->full_name_optional,
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
        $this->assertCount(0, Queue::all());
    }

    /** @test */
    function it_not_allow_to_register_a_new_patient()
    {
        $this->signIn();

        $patient = factory(Patient::class)->make();

        $this->postJson('api/patients', $patient->toArray())
        ->assertStatus(403);

        $this->assertDatabaseMissing('patients', [
            'full_name' => $patient->full_name,
            'full_name_optional' => $patient->full_name_optional,
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

    /** @test */
    function it_edit_a_patient()
    {
        $user = factory(User::class)->create();
        $user->allow('update-patients');
        $this->signIn($user);

        $patient = factory(Patient::class)->create();

        $this->putJson("api/patients/{$patient->id}", array_merge($patient->toArray(), [
            'full_name' => 'អ្នកជំងឺ',
            'full_name_optional' => 'patient edit',
            'gender' => 'M',
            'nationality_code' => 'KH',
            'phone' => '0987654',
            'identity_type' => 1,
            'identity_no' => '0786545',
        ]))
        ->assertStatus(200);

        $this->assertDatabaseHas('patients', [
            'id' => $patient->id,
            'full_name' => 'អ្នកជំងឺ',
            'full_name_optional' => 'patient edit',
            'gender' => 'M',
            'nationality_code' => 'KH',
            'phone' => '0987654',
            'identity_type' => 1,
            'identity_no' => '0786545',
        ]);
    }

    /** @test */
    function it_not_allow_to_edit_a_patient()
    {
        $this->signIn();

        $patient = factory(Patient::class)->create();

        $this->putJson("api/patients/{$patient->id}", array_merge($patient->toArray(), [
            'full_name' => 'អ្នកជំងឺ',
            'full_name_optional' => 'patient edit',
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
            'full_name_optional' => 'patient edit',
            'gender' => 'M',
            'nationality_code' => 'KH',
            'phone' => '0987654',
            'identity_type' => 1,
            'identity_no' => '0786545',
        ]);
    }

    /** @test */
    function it_update_a_patient_and_dont_meet_required_fields()
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

        $this->assertDatabaseHas('patients', collect($patient)->except(['age', 'identity_type_text'])->toArray());
    }

    /** @test */
    function it_fetch_patients()
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
                    'full_name_optional',
                    'dob',
                    'gender',
                    'nationality_code',
                    'phone',
                    'email',
                    'address',
                    'identity_type',
                    'identity_no',
                    'last_visited_at',
                    'referal',
                ],
            ],
        ]);
    }

    /** @test */
    function it_not_allow_to_fetch_patients()
    {
        $this->signIn();

        factory(Patient::class, 5)->create();

        $this->getJson('api/patients')
        ->assertStatus(403)
        ->assertJsonMissing(['data']);
    }

    /** @test */
    function it_show_a_patient()
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
                'full_name_optional',
                'dob',
                'gender',
                'nationality_code',
                'phone',
                'email',
                'address',
                'identity_type',
                'identity_no',
                'last_visited_at',
                'referal',
            ],
        ]);
    }

    /** @test */
    function it_not_allow_to_show_a_patient()
    {
        $this->signIn();

        $patient = factory(Patient::class)->create();

        $this->getJson("api/patients/{$patient->id}")
        ->assertStatus(403)
        ->assertJsonMissing(['data']);
    }

    /** @test */
    function it_delete_patients()
    {
        $user = factory(User::class)->create();
        $user->allow('delete-patients');
        $this->signIn($user);

        $patient = factory(Patient::class)->create();

        $this->deleteJson("api/patients/{$patient->id}")
        ->assertStatus(200);

        $this->assertDatabaseHas('patients', collect($patient->fresh())->except(['age', 'identity_type_text'])->toArray());
        $this->assertNotEquals(NULL, $patient->fresh()->deleted_at);
    }

    /** @test */
    function it_not_allow_to_delete_patients()
    {
        $this->signIn();

        $patient = factory(Patient::class)->create();

        $this->deleteJson("api/patients/{$patient->id}")
        ->assertStatus(403);

        $this->assertDatabaseHas('patients', collect($patient)->except(['age', 'identity_type_text'])->toArray());
        $this->assertEquals(NULL, $patient->fresh()->deleted_at);
    }
}
