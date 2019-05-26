<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    protected function store(Request $request)
    {
        $requestData = $request->validate([
            'username' => 'required|unique:users',
            'email' => 'nullable|unique:users',
            'password' => 'required|confirmed',
            'user_id' => 'nullable',
        ]);

        $user = User::create(array_merge($requestData, [
            'password' => Hash::make($request->password),
            'active' => true,
            'user_id' => null,
        ]));

        event(new Registered($user));

        return (new UserResource($user))->additional(['message' => 'Subscribere created']);
    }
}
