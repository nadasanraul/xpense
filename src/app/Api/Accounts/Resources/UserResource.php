<?php

namespace App\Api\Accounts\Resources;

use Illuminate\Http\Resources\Json\Resource;

/**
 * Class UserResource
 * @package App\Api\Accounts\Resources
 */
class UserResource extends Resource
{
    /**
     * Transform the  resource into an array
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'username' => $this->username,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
        ];
    }
}
