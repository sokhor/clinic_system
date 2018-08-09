<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function store(CreateUserRequest $request)
    {
        User::create(array_merge($request->all(), [
            'password' => bcrypt($request->password)
        ]));

        return response()->json(['message' => 'Create successfully'], 201);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->except(['id', 'username', 'password']));

        return response()->json(['message' => 'Update successfully'], 200);
    }
}
