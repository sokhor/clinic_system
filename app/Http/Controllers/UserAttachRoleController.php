<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Http\Requests\UserAttachRoleRequest;
use App\User;
use Bouncer;

class UserAttachRoleController extends Controller
{
    /**
     * Attach user's roles
     *
     * @param  \App\Http\Requests\UserAttachRoleRequest $request
     * @param  \App\User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UserAttachRoleRequest $request, User $user)
    {
        Bouncer::assign($request->roles)->to($user);

        return (new RoleResource($user->fresh()->roles))->additional(['message' => 'User was attached roles']);
    }
}
