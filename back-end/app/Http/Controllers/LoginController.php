<?php

namespace App\Http\Controllers;

use League\OAuth2\Server\AuthorizationServer;
use Zend\Diactoros\Response as Psr7Response;
use Zend\Diactoros\ServerRequest;
use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    protected $server;

    public function __construct(AuthorizationServer $server)
    {
        $this->server = $server;
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if(!($user = $this->hasValidCredentials($request)))
        {
            return response()->json(['invalid_credentials' => 'Invalid credentials'], 422);
        }

        $token = $this->retrieveAccessToken($user, $request);

        return response()->json($token, 200);
    }

    protected function retrieveAccessToken(User $user, Request $request)
    {
        $client = $user->clients->first();

        return json_decode($this->server->respondToAccessTokenRequest(
            (new ServerRequest)->withParsedBody([
                'grant_type' => 'password',
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'username' => $request->username,
                'password' => $request->password,
                'scope' => '',
            ]),
            new Psr7Response
        )->getBody()->__toString(), true);
    }

    protected function hasValidCredentials(Request $request)
    {
        $user = User::where('username', $request->username)
                ->where('active', true)
                ->first();

        return ! is_null($user) && app('hash')->check($request->password, $user->password) ? $user : false;
    }
}