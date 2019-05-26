<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserViewRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserDeleteRequest;
use App\Http\Resources\UserResource;
use App\Events\UserCreated;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Get users.
     *
     * @param  \App\Http\Requests\UserViewRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserViewRequest $request)
    {
        $users = User::withoutSuperAdmin()
            ->with('roles')
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->orWhere('username', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('email', 'LIKE', '%' . $request->search . '%');
                });
            })
            ->paginate();

        return UserResource::collection($users);
    }

    /**
     * show user.
     *
     * @param  \App\Http\Requests\UserViewRequest $request
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
     * @param  \App\Http\Requests\UserCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $user = User::create(array_merge($request->all(), [
            'password' => Hash::make($request->password),
            'user_id' => $request->user()->id,
        ]));

        return (new UserResource($user))->additional(['message' => 'User was created']);
    }

    /**
     * Updage a user.
     *
     * @param  \App\Http\Requests\UserUpdateRequest $request
     * @param  \App\User              $user
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->except(['username', 'password']));

        return (new UserResource($user->fresh()))->additional(['message' => 'User was updated']);
        ;
    }

    /**
     * Delete a user.
     *
     * @param  \App\Http\Requests\UserDeleteRequest $request
     * @param  \App\User              $user
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserDeleteRequest $request, User $user)
    {
        $user->delete();

        return response()->json(['message' => 'User was deleted']);
    }
}
