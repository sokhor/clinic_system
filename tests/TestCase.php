<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
        $user = $user ?: factory(\App\User::class)->create();

        Passport::actingAs($user);

        return $this;
    }

    protected function signInSuperAdmin($admin = null)
    {
        $admin = $admin ?: factory(\App\User::class)->create(['username' => 'superadmin']);

        Passport::actingAs($admin);

        return $this;
    }
}
