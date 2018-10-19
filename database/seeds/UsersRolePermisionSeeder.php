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

        App\User::truncate();
        $user = factory(App\User::class)->create([
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
        ]);
        Bouncer::allow($user)->everything();

        $this->seedPermissions();

        Artisan::call('passport:client', ['--password' => true, '--no-interaction' => true]);

        $client = Client::first();
        $client->update(['user_id' => $user->id]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Seed roles data
     *
     * @return void
     */
    protected function seedPermissions()
    {
        Bouncer::ability()->firstOrCreate(['name' => 'views-users', 'title' => 'View users']);
        Bouncer::ability()->firstOrCreate(['name' => 'create-users', 'title' => 'Create users']);
        Bouncer::ability()->firstOrCreate(['name' => 'edit-users', 'title' => 'Edit users']);
        Bouncer::ability()->firstOrCreate(['name' => 'delete-users', 'title' => 'Delete users']);
        Bouncer::ability()->firstOrCreate(['name' => 'reset-password-users', 'title' => 'Reset password users']);
        Bouncer::ability()->firstOrCreate(['name' => 'attach-roles-users', 'title' => 'Attach users roles']);

        Bouncer::ability()->firstOrCreate(['name' => 'view-roles', 'title' => 'View roles']);
        Bouncer::ability()->firstOrCreate(['name' => 'create-roles', 'title' => 'Create roles']);
        Bouncer::ability()->firstOrCreate(['name' => 'edit-roles', 'title' => 'Edit roles']);
        Bouncer::ability()->firstOrCreate(['name' => 'delete-roles', 'title' => 'Delete roles']);

        Bouncer::ability()->firstOrCreate(['name' => 'view-wards', 'title' => 'View wards']);
        Bouncer::ability()->firstOrCreate(['name' => 'create-wards', 'title' => 'Create wards']);
        Bouncer::ability()->firstOrCreate(['name' => 'update-wards', 'title' => 'Update wards']);
        Bouncer::ability()->firstOrCreate(['name' => 'delete-wards', 'title' => 'Delete wards']);
    }
}
