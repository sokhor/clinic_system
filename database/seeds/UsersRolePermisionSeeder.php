<?php

use Illuminate\Database\Seeder;
use Laravel\Passport\Client;

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

        Artisan::call('passport:client', ['--password' => true, '--no-interaction' => true]);

        App\User::truncate();

        $user = factory(App\User::class)->create(['username' => 'superadmin', 'email' => 'superadmin@example.com']);
        Bouncer::allow($user)->everything();

        Bouncer::role()->create([ 'name' => 'receptionist', 'title' => 'Receptionist']);
        $receptionist = factory(App\User::class)->create([ 'username' => 'receptionist', 'email' => 'receptionist@mail.com']);
        Bouncer::assign('receptionist')->to($receptionist);

        Bouncer::role()->create([ 'name' => 'doctor', 'title' => 'Doctor']);
        $doctor = factory(App\User::class)->create([ 'username' => 'doctor', 'email' => 'doctor@mail.com']);
        Bouncer::assign('doctor')->to($doctor);

        Bouncer::role()->create([ 'name' => 'nurse', 'title' => 'Nurse']);
        $nurse = factory(App\User::class)->create([ 'username' => 'nurse', 'email' => 'nurse@mail.com']);
        Bouncer::assign('nurse')->to($nurse);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
