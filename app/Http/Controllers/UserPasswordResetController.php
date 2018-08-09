<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserPasswordResetRequest;

class UserPasswordResetController extends Controller
{
    public function update(UserPasswordResetRequest $request, User $user)
    {
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['message' => 'Password has reset']);
    }
}
