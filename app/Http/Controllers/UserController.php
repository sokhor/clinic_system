<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\ViewUserRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Get users.
     *
     * @param  \App\Http\Requests\ViewUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ViewUserRequest $request)
    {
        return UserResource::collection(User::withoutSuperAdmin()->paginate());
    }

    /**
     * show user.
     *
     * @param  \App\Http\Requests\ViewUserRequest $request
     * @param  \App\User            $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ViewUserRequest $request, User $user)
    {
        return new UserResource($user);
    }

    /**
     * Create a new user.
     *
     * @param  \App\Http\Requests\CreateUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
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
    public function update(UpdateUserRequest $request, User $user)
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
    public function destroy(DeleteUserRequest $request, User $user)
    {
        $user->delete();

        return response()->json(['message' => 'Delete successfully']);
    }
}
