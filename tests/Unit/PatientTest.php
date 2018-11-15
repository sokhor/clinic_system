<?php

namespace Tests\Unit;

use App\Patient\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PatientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_generate_patient_code()
    {
        $patient = factory(Patient::class)->create();

        $this->assertEquals('PA' . $patient->id, $patient->code);
    }
}
