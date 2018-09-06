<?php

namespace App\Http\Controllers;

use League\OAuth2\Server\AuthorizationServer;
use Zend\Diactoros\Response as Psr7Response;
use Zend\Diactoros\ServerRequest;
use Illuminate\Http\Request;
use App\Http\Resources\AuthenticatedUserResource;
use App\User;
use Auth;

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
            return response()->json(['message' => 'Invalid credentials'], 422);
        }

        if(!($token = $this->retrieveAccessToken($user, $request)))
        {
            return response()->json(['message' => 'This user is unauthorized'], 422);
        }

        $user = $this->setAuthenticatedUser($user);

        return new AuthenticatedUserResource(compact('user', 'token'));
    }

    protected function retrieveAccessToken(User $user, Request $request)
    {
        if(is_null($client = $user->clients->first()))
        {
            return false;
        }

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
        )->getBody()->__toString());
    }

    protected function hasValidCredentials(Request $request)
    {
        $user = User::where('username', $request->username)
                ->where('active', true)
                ->first();

        return ! is_null($user) && app('hash')->check($request->password, $user->password) ? $user : false;
    }

    protected function setAuthenticatedUser(User $user)
    {
        Auth::setUser($user);

        return Auth::user();
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response(null, 202);
    }
}