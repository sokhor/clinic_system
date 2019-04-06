<?php

use Illuminate\Database\Seeder;
use Domain\HumanResource\Models\EmployeePosition;

class EmployeePositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmployeePosition::truncate();

        EmployeePosition::insert([
            ['name' => 'Nurse', 'order' => 1],
            ['name' => 'Doctor', 'order' => 2],
            ['name' => 'Midwife', 'order' => 3],
            ['name' => 'Cashier', 'order' => 4],
            ['name' => 'Pharmacist', 'order' => 5],
        ]);
    }
}
