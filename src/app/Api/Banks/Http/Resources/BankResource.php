<?php

namespace App\Api\Banks\Http\Resources;

use App\Api\Core\Resources\BaseResource;

/**
 * Class BankResource
 * @package App\Api\Banks\Resources
 */
class BankResource extends BaseResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->attributes = [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'description' => $this->description,
            'country' => $this->country,
        ];
    }
}
