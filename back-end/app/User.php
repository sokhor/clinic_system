<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens, HasRolesAndAbilities;

    protected $fillable = ['username', 'email', 'password', 'active'];

    protected $hidden = ['password', 'remember_token'];

    protected $dates = ['deleted_at'];

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }
}