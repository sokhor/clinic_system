<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        DB::table('provinces')->insert([
            ['province_code' => 'PNP', 'province_en' => 'Phnom Penh', 'province_kh' => 'ភ្នំពេញ'],
            ['province_code' => 'BAT', 'province_en' => 'Battambong', 'province_kh' => 'បាត់ដំបង'],
            ['province_code' => 'SPE', 'province_en' => 'Kampong Speu', 'province_kh' => 'កំពង់ស្ពឺ'],
        ]);

        DB::table('districts')->insert([
            ['province_code' => 'PNP', 'district_en' => 'Chamkarmorn', 'district_kh' => 'ចំការមន'],
            ['province_code' => 'PNP', 'district_en' => 'Tuolkork', 'district_kh' => 'ទួលគោក'],
            ['province_code' => 'PNP', 'district_en' => 'Dongkor', 'district_kh' => 'ដង្កោ'],
        ]);

        DB::table('communes')->insert([
            ['province_code' => 'PNP', 'district_id' => 1, 'commune_en' => 'Tonle Basac', 'commune_kh' => 'ទន្លេបាសាក់'],
            ['province_code' => 'PNP', 'district_id' => 1, 'commune_en' => 'Tuoltumpoung', 'commune_kh' => 'ទួលទំពូង'],
            ['province_code' => 'PNP', 'district_id' => 1, 'commune_en' => 'Boeng Trabek', 'commune_kh' => 'បឹងត្របែក'],
        ]);

        DB::table('villages')->insert([
            ['province_code' => 'PNP', 'district_id' => 1, 'commune_id' => 1, 'village_en' => 'Phum 1', 'village_kh' => 'ភូមិ ១'],
            ['province_code' => 'PNP', 'district_id' => 1, 'commune_id' => 1, 'village_en' => 'Phum 2', 'village_kh' => 'ភូមិ ២'],
            ['province_code' => 'PNP', 'district_id' => 1, 'commune_id' => 1, 'village_en' => 'Phum 3', 'village_kh' => 'ភូមិ ៣'],
        ]);
    }

    /** @test */
    public function fetch_provinces()
    {
        $this->getJson('api/provinces')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'province_code',
                        'province_en',
                        'province_kh',
                    ]
                ]
            ]);
    }

    /** @test */
    public function fetch_districts()
    {
        $this->getJson('api/districts')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'province_code',
                        'district_en',
                        'district_kh',
                    ]
                ]
            ]);
    }

    /** @test */
    public function fetch_communes()
    {
        $response = $this->getJson('api/communes')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'province_code',
                        'district_id',
                        'commune_en',
                        'commune_kh',
                    ]
                ]
            ]);
    }

    /** @test */
    public function fetch_villages()
    {
        $response = $this->getJson('api/villages')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'province_code',
                        'district_id',
                        'commune_id',
                        'village_en',
                        'village_kh',
                    ]
                ]
            ]);
    }
}
