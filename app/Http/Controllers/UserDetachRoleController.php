<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserDetachRoleRequest;
use App\Http\Resources\RoleResource;
use App\User;
use Bouncer;

class UserDetachRoleController extends Controller
{
    /**
     * Detach user's roles
     *
     * @param  \App\Http\Requests\UserDettachRoleRequest $request
     * @param  \App\User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UserDetachRoleRequest $request, User $user)
    {
        Bouncer::retract($request->roles)->from($user);

        return (new RoleResource($user->fresh()->roles))->additional(['message' => 'User was detached roles']);
    }
}
