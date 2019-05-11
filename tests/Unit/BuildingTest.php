<?php

namespace Tests\Unit;

use App\Place\Models\Building;
use App\Place\Models\Ward;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BuildingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_delete_the_related_wards_pivot_if_building_deleted()
    {
        $wards = factory(Ward::class, 2)->create();
        $building = factory(Building::class)->create();

        //Attach wards
        $building->wards()->attach($wards->pluck('id'));

        $pivot = DB::table('building_ward')
        ->where('building_id', $building->id)
        ->whereIn('ward_id', $wards->pluck('id'))
        ->get();

        $this->assertCount(2, $pivot);

        //Delete building
        $building->delete();

        $pivot = DB::table('building_ward')
        ->where('building_id', $building->id)
        ->whereIn('ward_id', $wards->pluck('id'))
        ->get();

        $this->assertCount(0, $pivot);
    }
}
