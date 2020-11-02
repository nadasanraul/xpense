<?php

namespace App\Api\Banks\Resources;

use Illuminate\Http\Resources\Json\Resource;

/**
 * Class AccountTransactionResource
 * @package App\Api\Banks\Resources
 */
class AccountTransactionResource extends Resource
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
            'title' => $this->title,
            'amount' => $this->amount,
            'type' => $this->type,
            'completed_at' => $this->completed_at,
        ];
    }
}
