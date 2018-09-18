<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserViewRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserDeleteRequest;
use App\Http\Requests\UserAttachRoleRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\RoleResource;
use Bouncer;

class UserController extends Controller
{
    /**
     * Get users.
     *
     * @param  \App\Http\Requests\ViewUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserViewRequest $request)
    {
        return UserResource::collection(User::withoutSuperAdmin()->paginate());
    }

    /**
     * show user.
     *
     * @param  \App\Http\Requests\ViewUserRequest $request
     * @param  uinteger           $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(UserViewRequest $request, $id)
    {
        return new UserResource(User::with('roles')->withoutSuperAdmin()->find($id));
    }

    /**
     * Create a new user.
     *
     * @param  \App\Http\Requests\CreateUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        User::create(array_merge($request->all(), [
            'password' => bcrypt($request->password)
        ]));

        return response()->json(['message' => 'Create successfully'], 201);
    }

    /**
     * Updage a user.
     *
     * @param  \App\Http\Requests\UpdateUserRequest $request
     * @param  \App\User              $user
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->except(['id', 'username', 'password']));

        return response()->json(['message' => 'Update successfully']);
    }

    /**
     * Delete a user.
     *
     * @param  \App\Http\Requests\DeleteUserRequest $request
     * @param  \App\User              $user
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserDeleteRequest $request, User $user)
    {
        $user->delete();

        return response()->json(['message' => 'Delete successfully']);
    }

    public function attachRoles(UserAttachRoleRequest $request, User $user)
    {
        Bouncer::assign($request->roles)->to($user);

        return response()->json(new RoleResource($user->fresh()->roles), 201);
    }
}
