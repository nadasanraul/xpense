<?php

namespace App\Api\Banks\Resources;

use Illuminate\Http\Resources\Json\Resource;

/**
 * Class BankResource
 * @package App\Api\Banks\Transformers
 */
class BankResource extends Resource
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
            'country' => $this->country,
        ];
    }
}
