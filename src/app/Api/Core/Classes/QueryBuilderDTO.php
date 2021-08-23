<?php

namespace App\Core\Classes;

use Illuminate\Database\Query\Builder;

/**
 * Class QueryBuilderDTO
 * @package App\Classes
 */
class QueryBuilderDTO
{
    /**
     * The array of fields and values to be searched
     *
     * @var array
     */
    public $search = [];

    /**
     * The array of fields the query should be sorted by
     *
     * @var array
     */
    public $sort = [];

    /**
     * The array of fields to select
     *
     * @var array
     */
    public $fields = [];

    /**
     * The built query
     *
     * @var Builder
     */
    public $query;

    /**
     * The number of resources for one page
     *
     * @var string
     */
    public $limit;
}
