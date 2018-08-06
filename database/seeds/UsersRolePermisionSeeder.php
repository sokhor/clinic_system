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

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
