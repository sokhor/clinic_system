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
    public function it_view_companies()
    {
        factory(Company::class, 2)->create();

        $this->signIn()
            ->allow('view', Company::class)
            ->getJson('api/companies')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'company_name_kh',
                        'company_name_en',
                        'logo',
                        'type_of_business',
                        'telephone',
                        'mobilephone',
                        'email',
                        'website',
                        'postcode',
                        'building',
                        'street',
                        'village',
                        'commune',
                        'district',
                        'province',
                    ],
                ],
            ]);
    }

    /** @test */
    public function it_not_allow_to_view_companies()
    {
        factory(Company::class, 2)->create();

        $this->signIn()
            ->getJson('api/companies')
            ->assertStatus(403)
            ->assertJsonMissing(['data']);
    }

    /** @test */
    public function it_create_a_company()
    {
        $company = factory(Company::class)->make();

        $response = $this->signIn()
            ->allow('create', Company::class)
            ->postJson('api/companies', $company->toArray())
            ->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'company_name_kh',
                    'company_name_en',
                    'logo',
                    'type_of_business',
                    'telephone',
                    'mobilephone',
                    'email',
                    'website',
                    'postcode',
                    'building',
                    'street',
                    'village',
                    'commune',
                    'district',
                    'province',
                ],
            ]);

        $this->assertDatabaseHas('companies', $company->toArray());
    }

    /** @test */
    public function validate_fields_for_creating_a_company()
    {
        $this->signIn()
            ->allow('create', Company::class)
            ->postJson('api/companies', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'company_name_en',
                'telephone',
                'building',
                'street',
                'village',
                'commune',
                'district',
                'province',
            ]);
    }

    /** @test */
    public function it_not_allow_to_create_a_company()
    {
        $company = factory(Company::class)->make();

        $this->signIn()
            ->postJson('api/companies', $company->toArray())
            ->assertStatus(403);

        $this->assertDatabaseMissing('companies', $company->toArray());
    }
}
