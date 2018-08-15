<?php

use Illuminate\Database\Seeder;

class UsersRolePermisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        App\User::truncate();
        $user = factory(App\User::class)->create([
            'username' => 'superadmin',
            'email' => 'nak2bo@gmail.com',
        ]);

        Bouncer::allow($user)->everything();
        Bouncer::ability()->firstOrCreate(['name' => 'create-users', 'title' => 'Create users']);
        Bouncer::ability()->firstOrCreate(['name' => 'edit-users', 'title' => 'Edit users']);
        Bouncer::ability()->firstOrCreate(['name' => 'delete-users', 'title' => 'Delete users']);
        Bouncer::ability()->firstOrCreate(['name' => 'reset-password-users', 'title' => 'Reset users password']);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
