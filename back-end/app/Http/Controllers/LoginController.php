<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\User;

class LoginController extends Controller
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if(!($user = $this->hasValidCredentials($request)))
        {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $token = $this->retrieveAccessToken($user, $request);

        return response()->json($token, 200);
    }

    protected function retrieveAccessToken(User $user, Request $request)
    {
        $client = $user->clients->first();

        $response = $this->client->post(url('oauth/token'), [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'username' => $request->username,
                'password' => $request->password,
                'scope' => '',
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    protected function hasValidCredentials(Request $request)
    {
        $user = User::where('username', $request->username)
                ->where('active', true)
                ->first();

        return ! is_null($user) && app('hash')->check($request->password, $user->password) ? $user : false;
    }
}