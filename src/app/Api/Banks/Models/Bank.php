<?php

namespace App\Api\Banks\Models;

use App\Api\Core\Models\BaseModel;

/**
 * Class Bank
 * @property string $uuid
 * @property string $name
 * @property string $description
 * @property string $country
 * @package App\Api\Banks\Models
 */
class Bank extends BaseModel
{
    /**
     * The attributes that the model can be sorted by
     *
     * @var array
     */
    protected $sortingFields = ['name', 'country'];

    /**
     * The attributes that can be used to search the model
     *
     * @var array
     */
    protected $searchFields = ['name', 'description', 'country'];
}
