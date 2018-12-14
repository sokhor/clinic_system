<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthenticatedUserResource;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use League\OAuth2\Server\AuthorizationServer;
use Zend\Diactoros\Response as Psr7Response;
use Zend\Diactoros\ServerRequest;

class LoginController extends Controller
{
    protected $server;

    /**
     * Instantiate instance.
     *
     * @param \League\OAuth2\Server\AuthorizationServer $server
     */
    public function __construct(AuthorizationServer $server)
    {
        $this->server = $server;
    }

    /**
     * Log the user in.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Retrieve user's access token.
     *
     * @param  \App\User    $user
     * @param  \Illuminate\Http\Request $request
     *
     * @return string|boolean
     */
    protected function retrieveAccessToken(User $user, Request $request)
    {
        if(is_null($client = Passport::client()->first()))
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

    /**
     * Validate if username and password correct.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return boolean
     */
    protected function hasValidCredentials(Request $request)
    {
        $user = User::where('username', $request->username)
                ->where('active', true)
                ->first();

        return ! is_null($user) && app('hash')->check($request->password, $user->password) ? $user : false;
    }

    /**
     * Set the authenticated user.
     *
     * @param \App\User $user
     *
     * @return \App\User
     */
    protected function setAuthenticatedUser(User $user)
    {
        Auth::setUser($user);

        return $user;
    }

    /**
     * Logout the authenticated user.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response(null, 200);
    }

    /**
     * Check if user is authenticated
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticated()
    {
        return response(request()->user());
    }
}