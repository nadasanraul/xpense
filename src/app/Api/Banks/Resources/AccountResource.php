<?php

namespace App\Api\Banks\Resources;

use Illuminate\Http\Resources\Json\Resource;

/**
 * Class AccountResource
 * @package App\Api\Banks\Resources
 */
class AccountResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'description' => $this->description,
            'balance' => $this->balance,
            'number' => $this->number,
            'user' => $this->user,
            'bank' => $this->bank,
        ];
    }
}
