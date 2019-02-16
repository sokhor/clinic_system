<?php

namespace Tests;

use App\User;
use Bouncer;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $user;

    protected function signInSuperAdmin($admin = null)
    {
        $admin = $admin ?: factory(User::class)->create(['username' => 'superadmin']);
        Bouncer::allow($admin)->everything();

        Passport::actingAs($admin);

        return $this;
    }


    protected function signIn($user = null)
    {
        $this->user = $user ?: $this->user ?: factory(User::class)->create();

        Passport::actingAs($this->user);

        return $this;
    }

    protected function allowEverything($user = null)
    {
        $this->user = $user ?: $this->user ?: factory(User::class)->create();

        Bouncer::allow($this->user)->everything();

        return $this;
    }

    protected function allow($ability, $model = null, $user = null)
    {
        $this->user = $user ?: $this->user ?: factory(User::class)->create();

        if(is_null($model)) {
            Bouncer::allow($this->user)->to($ability);
        }
        else {
            Bouncer::allow($this->user)->to($ability, $model);
        }

        return $this;
    }
}
