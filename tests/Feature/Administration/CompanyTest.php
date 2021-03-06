<?php

namespace Tests\Feature\Administration;

use App\User;
use Domain\Administration\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
                        'user_id',
                        'company_name_kh',
                        'company_name_en',
                        'logo',
                        'type_of_business',
                        'telephone',
                        'mobilephone',
                        'email',
                        'website',
                        'address',
                        'province',
                        'postcode',
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
    public function it_view_a_company()
    {
        $company = factory(Company::class)->create();

        $this->signIn()
            ->allow('view', $company)
            ->getJson('api/companies/' . $company->id)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'user_id',
                    'company_name_kh',
                    'company_name_en',
                    'logo',
                    'type_of_business',
                    'telephone',
                    'mobilephone',
                    'email',
                    'website',
                    'address',
                    'province',
                    'postcode',
                ],
            ]);
    }

    /** @test */
    public function it_not_allow_to_view_a_company()
    {
        $company = factory(Company::class)->create();

        $this->signIn()
            ->getJson('api/companies/' . $company->id)
            ->assertStatus(403)
            ->assertJsonMissing(['data']);
    }


    /** @test */
    public function it_create_a_company()
    {
        $company = factory(Company::class)->make();

        $this->signIn()
            ->allow('create', Company::class)
            ->postJson('api/companies', $company->toArray())
            ->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'user_id',
                    'company_name_kh',
                    'company_name_en',
                    'logo',
                    'type_of_business',
                    'telephone',
                    'mobilephone',
                    'email',
                    'website',
                    'address',
                    'province',
                    'postcode',
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
                'address',
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

    /** @test */
    public function it_edit_a_company()
    {
        $company = factory(Company::class)->create();

        $this->signIn()
            ->allow('update', $company)
            ->putJson('api/companies/' . $company->id, array_merge($company->toArray(), [
                'company_name_en' => 'Edit company name',
            ]))
            ->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'user_id',
                    'company_name_kh',
                    'company_name_en',
                    'logo',
                    'type_of_business',
                    'telephone',
                    'mobilephone',
                    'email',
                    'website',
                    'address',
                    'province',
                    'postcode',
                ],
            ]);

        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'company_name_en' => 'Edit company name',
        ]);
    }

    /** @test */
    public function validate_fields_for_editing_a_company()
    {
        $company = factory(Company::class)->create();

        $this->signIn()
            ->allow('update', $company)
            ->putJson('api/companies/' . $company->id, [])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'company_name_en',
                'telephone',
                'address',
                'province',
            ]);
    }

    /** @test */
    public function it_not_allow_to_edit_a_company()
    {
        $company = factory(Company::class)->create();

        $this->signIn()
            ->putJson('api/companies/' . $company->id, array_merge($company->toArray(), [
                'company_name_en' => 'Edit company name',
            ]))
            ->assertStatus(403);

        $this->assertDatabaseMissing('companies', [
            'id' => $company->id,
            'company_name_en' => 'Edit company name',
        ]);
    }

    /** @test */
    public function it_upload_the_company_logo()
    {
        Storage::fake();

        // When creating
        $logo1 = UploadedFile::fake()->image('logo1.png');

        $response = $this->signIn(factory(User::class)->create())
            ->allow('create', Company::class)
            ->json('POST', 'api/companies/logos', ['logo' => $logo1])
            ->assertStatus(201);

        Storage::disk()->assertExists('companies/' . $logo1->hashName());

        $this->assertEquals([
            'data' => 'companies/' . $logo1->hashName()
        ], json_decode($response->getContent(), true));


        // When editing
        $logo2 = UploadedFile::fake()->image('logo2.png');

        $response = $this->signIn(factory(User::class)->create())
            ->allow('edit', Company::class)
            ->json('POST', 'api/companies/logos', ['logo' => $logo2])
            ->assertStatus(201);

        Storage::disk()->assertExists('companies/' . $logo2->hashName());

        $this->assertEquals([
            'data' => 'companies/' . $logo2->hashName()
        ], json_decode($response->getContent(), true));
    }

    /** @test */
    public function company_logo_must_be_image()
    {
        Storage::fake();

        $pdf = UploadedFile::fake()->create('file.pdf');

        $this->signIn()
            ->allow('create', Company::class)
            ->json('POST', 'api/companies/logos', ['logo' => $pdf])
            ->assertStatus(422);

        Storage::disk()->assertMissing('companies/' . $pdf->hashName());
    }

    /** @test */
    public function it_not_allow_to_upload_the_company_logo()
    {
        $logo = UploadedFile::fake()->image('logo.png');

        $this->signIn()
            ->json('POST', 'api/companies/logos', ['logo' => $logo])
            ->assertStatus(403);

        Storage::disk()->assertMissing('companies/' . $logo->hashName());
    }

    /** @test */
    public function it_delete_a_company()
    {
        $company = factory(Company::class)->create();

        $this->signIn()
            ->allow('delete', $company)
            ->deleteJson("api/companies/{$company->id}")
            ->assertStatus(200);

        $company = $company->fresh();
        $this->assertNotNull($company->deleted_at);
        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
        ]);
    }

    /** @test */
    public function it_not_allow_delete_a_company()
    {
        $company = factory(Company::class)->create();

        $this->signIn()
            ->deleteJson("api/companies/{$company->id}")
            ->assertStatus(403);

        $company = $company->fresh();
        $this->assertNull($company->deleted_at);
        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
        ]);
    }
}
