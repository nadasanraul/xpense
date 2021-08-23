<?php

namespace App\Api\Core\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;

/**
 * Class BaseResource
 * @package App\Api\Core\Resources
 */
abstract class BaseResource extends Resource
{
    /**
     * The attributes that can be searched
     *
     * @var array
     */
    protected static $searchable = [];

    /**
     * The attributes that can be sorted
     *
     * @var array
     */
    protected static $sortable = [];

    /**
     * The resource attributes
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Mapping the attributes to an array format
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return $this->attributes;
    }
}
