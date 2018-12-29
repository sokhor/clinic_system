<?php

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::truncate();

        Position::insert([
            ['name' => 'Nurse', 'order' => null],
            ['name' => 'Doctor', 'order' => null],
            ['name' => 'Midwife', 'order' => null],
            ['name' => 'Cashier', 'order' => null],
            ['name' => 'Pharmacist', 'order' => null],
        ]);
    }
}
