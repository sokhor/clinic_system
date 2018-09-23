<?php

namespace App\Http\Controllers;

use Laravel\Passport\ClientRepository;
use App\User;
use App\Http\Requests\UserViewRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserDeleteRequest;
use App\Http\Requests\UserAttachRoleRequest;
use App\Http\Requests\UserDetachRoleRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\RoleResource;
use Bouncer;

class UserController extends Controller
{
    protected $client;

    public function __construct(ClientRepository $client)
    {
        $this->client = $client;
    }

    /**
     * Get users.
     *
     * @param  \App\Http\Requests\ViewUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserViewRequest $request)
    {
        return UserResource::collection(User::withoutSuperAdmin()->with('roles')->paginate());
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
        $user = User::create(array_merge($request->all(), [
            'password' => bcrypt($request->password)
        ]));

        $this->client->create($user->id, $user->username, '', false, true);

        return response()->json(new UserResource($user), 201);
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

        return response()->json(new UserResource($user->fresh()));
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

        return response()->json(new UserResource($user->fresh()));
    }

    /**
     * Attach user's roles
     *
     * @param  \App\Http\Requests\UserAttachRoleRequest $request
     * @param  \App\User                  $user
     *
     * @return \Illuminate\Http\Response
     */
    public function attachRoles(UserAttachRoleRequest $request, User $user)
    {
        Bouncer::assign($request->roles)->to($user);

        return response()->json(new RoleResource($user->fresh()->roles), 201);
    }

    /**
     * Detach user's roles
     *
     * @param  \App\Http\Requests\UserDettachRoleRequest $request
     * @param  \App\User                   $user
     *
     * @return \Illuminate\Http\Response
     */
    public function detachRoles(UserDetachRoleRequest $request, User $user)
    {
        Bouncer::retract($request->roles)->from($user);

        return response()->json(new RoleResource($user->fresh()->roles));
    }
}
