<?php

namespace Tests\Unit;

use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PatientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generate_patient_code()
    {
        $patient = factory(Patient::class)->create();
        $this->assertEquals('PA' . sprintf("%'.03d", $patient->id), $patient->code);

        factory(Patient::class, 999)->create();
        $patient = factory(Patient::class)->create();
        $this->assertEquals('PA' . sprintf("%'.03d", $patient->id), $patient->code);
    }
}
