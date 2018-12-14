<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthenticatedUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'username' => $this['user']->username,
            'roles' => $this['user']->roles->map(function($role) {
                return [
                    'name' => $role->name,
                    'title' => $role->title,
                ];
            }),
            'abilities' => $this['user']->abilities->map(function($abilitie) {
                return [
                    'name' => $abilitie->name,
                    'title' => $abilitie->title,
                ];
            }),
            'email' => $this['user']->email,
            'access_token' => $this['token']->access_token,
            'expires_in' => $this['token']->expires_in,
            'refresh_token' => $this['token']->refresh_token,
            'token_type' => $this['token']->token_type,
        ];
    }
}
