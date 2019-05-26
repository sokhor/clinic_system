<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Passport\HasApiTokens;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens, HasRolesAndAbilities;

    protected $fillable = ['username', 'email', 'password', 'active', 'user_id'];

    protected $hidden = ['password', 'remember_token'];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'active' => 'bool',
    ];

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    public function scopeWithoutSuperAdmin(Builder $builder)
    {
        return $builder->where('username', '!=', 'superadmin');
    }

    public function isSubscriber()
    {
        return is_null($this->user_id);
    }
}
