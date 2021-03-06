<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Domain\HumanResource\Models\Employee;
use Illuminate\Support\Carbon;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    private function validParams($override = [])
    {
        return array_merge([
            'name_native' => 'នីតា',
            'name_latin' => 'Nita',
            'born' => '20-01-1980',
            'gender' => 'Male',
            'marital' => 'Single',
            'emp_no' => '0000456',
            'address' => [
                'house' => '#130',
                'street' => 'St. 130',
                'village' =>'Tonle Basac',
                'district' => 'Chamkarmorn',
                'city_province' => 'Phnom Penh',
            ],
            'position_id' => 1,
            'id_card_type' => 'National ID',
            'id_card_no' => 'N0499900000',
            'hiring_date' => '17-10-2017',
            'hiring_status' => 'Active'
        ], $override);
    }

    /** @test */
    public function it_create_a_new_employee()
    {
        $employee = [
            'name_native' => 'នីតា',
            'name_latin' => 'Nita',
            'born' => '20-01-1980',
            'gender' => 'Male',
            'marital' => 'Single',
            'emp_no' => '0000456',
            'address' => [
                'house' => '#130',
                'street' => 'St. 130',
                'village' =>'Tonle Basac',
                'district' => 'Chamkarmorn',
                'city_province' => 'Phnom Penh',
            ],
            'position_id' => 1,
            'id_card_type' => 'National ID',
            'id_card_no' => 'N0499900000',
            'hiring_date' => '17-10-2017',
            'hiring_status' => 'Active'
        ];
        
        $response = $this->signIn()->postJson('api/employees', $employee);

        $this->assertDatabaseHas('employees', [
            'name_native' => $employee['name_native'],
            'name_latin' => $employee['name_latin'],
            'born' => Carbon::createFromFormat(config('app.date_format'), $employee['born'])->format('Y-m-d'),
            'gender' => $employee['gender'],
            'marital' => $employee['marital'],
            'emp_no' => $employee['emp_no'],
            'address' => json_encode($employee['address']),
            'position_id' => $employee['position_id'],
            'id_card_type' => $employee['id_card_type'],
            'id_card_no' => $employee['id_card_no'],
            'hiring_date' => Carbon::createFromFormat(config('app.date_format'), $employee['hiring_date'])->format('Y-m-d'),
            'hiring_status' => $employee['hiring_status'],
        ]);

        $response->assertStatus(201)->assertJson(['data' => $employee]);
    }

    /** @test */
    public function it_update_an_employee()
    {
        $employee = factory(Employee::class)->create();
        $updateInput = $this->validParams([
            'name_native' => 'ឈ្មោះថ្មី',
            'name_latin' => 'New name',
        ]);
        
        $response = $this->signIn()->putJson('api/employees/' . $employee->id, $updateInput);

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'name_native' => 'ឈ្មោះថ្មី',
            'name_latin' => 'New name',
        ]);

        $response->assertStatus(200)->assertJson(['data' => $updateInput]);
    }

    /** @test */
    public function it_delete_an_employee()
    {
        $employee = factory(Employee::class)->create();
        
        $response = $this->signIn()->deleteJson('api/employees/' . $employee->id);

        $response->assertStatus(200);
        $this->assertNull(Employee::find($employee->id));
        $this->assertDatabaseHas('employees', ['id' => $employee->id]);
    }
}
