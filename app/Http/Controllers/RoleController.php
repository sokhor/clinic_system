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
        $role = Bouncer::role()->firstOrCreate([
            'name' => kebab_case($request->role_name),
            'title' => ($request->role_name),
        ]);

        foreach ($request->abilities as $ability) {
            Bouncer::allow($role->name)->to($ability);
        }

        return (new RoleResource($role))->additional(['message' => 'Role created']);
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
        $role->name = kebab_case($request->role_name);
        $role->title = $request->role_name;

        $role->save();

        foreach ($request->abilities as $ability) {
            Bouncer::allow($role->name)->to($ability);
        }

        return (new RoleResource($role->fresh()))->additional(['message' => 'Role updated']);
        ;
    }

    /**
     * Get roles.
     *
     * @param  \App\Http\Requests\RoleViewRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RoleViewRequest $request)
    {
        $roles = Role::with('abilities')
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->search . '%');
            });

        return RoleResource::collection(
            $request->perPage != -1 ? $roles->paginate($request->perPage) : $roles->get()
        );
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

        return response()->json(['message' => 'Role deleted']);
        ;
    }

    /**
     * Show role.
     *
     * @param  RoleViewRequest $request
     * @param  unsigned integer         $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(RoleViewRequest $request, $id)
    {
        return new RoleResource(Role::with('abilities')->findOrFail($id));
    }
}
