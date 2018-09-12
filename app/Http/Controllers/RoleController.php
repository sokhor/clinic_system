<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Silber\Bouncer\Database\Role;
use Bouncer;
use App\Http\Resources\RoleResource;
use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Http\Requests\RoleViewRequest;
use App\Http\Requests\RoleDeleteRequest;

class RoleController extends Controller
{
    /**
     * Create a new role.
     *
     * @param  \App\Http\Requests\RoleCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RoleCreateRequest $request)
    {
        return response(new RoleResource(Bouncer::role()->firstOrCreate($request->all())), 201);
    }

    /**
     * Edit role
     *
     * @param  \App\Http\Requests\RoleUpdateRequest $request
     * @param  \Silber\Bouncer\Database\Role $role
     *
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $role->name = $request->name;
        $role->title = $request->title;

        $role->save();

        return new RoleResource($role->fresh());
    }

    /**
     * Get roles.
     *
     * @param  \App\Http\Requests\oleViewRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RoleViewRequest $request)
    {
        return RoleResource::collection(Role::paginate());
    }

    /**
     * Delete role.
     *
     * @param  \App\Http\Requests\RoleDeleteRequest $request
     * @param  \Silber\Bouncer\Database\Role $role
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoleDeleteRequest $request, Role $role)
    {
        $role->delete();

        return new RoleResource($role);
    }
}
