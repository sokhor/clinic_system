<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LocationsSeeder::class);
        $this->call(EmployeePositionsTableSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(UsersRolePermisionSeeder::class);
        $this->call(WardsTableSeeder::class);
        $this->call(BuildingsTableSeeder::class);
        $this->call(RoomsTableSeeder::class);
    }
}
