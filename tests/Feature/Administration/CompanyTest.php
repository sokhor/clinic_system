<?php

namespace Tests\Feature\Administration;

use Domain\Administration\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_create_a_company()
    {
        $this->withoutExceptionHandling();
        $company = factory(Company::class)->make();

        $this->signIn()
            ->allow('create-companies')
            ->postJson('api/companies', $company->toArray())
            ->assertStatus(201);

        $this->assertDatabaseHas('companies', $company->toArray());
    }
}
