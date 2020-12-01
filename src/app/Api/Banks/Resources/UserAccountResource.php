<?php

namespace App\Api\Banks\Resources;

use Illuminate\Http\Resources\Json\Resource;

/**
 * Class UserAccountResource
 * @package App\Api\Banks\Resources
 */
class UserAccountResource extends Resource
{
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'description' => $this->description,
            'balance' => $this->balance,
            'number' => $this->number,
            'bank' => $this->bank,
        ];
    }
}
