<?php

namespace App\Api\Banks\Models;

use App\Api\Core\Models\BaseModel;

/**
 * Class ExpenseCategory
 * @package App\Api\Banks\Models
 */
class ExpenseCategory extends BaseModel
{
    /**
     * The attributes that are mass assignable
     *
     * @var string[]
     */
    protected $fillable = ['uuid', 'name', 'user_id'];

    /**
     * The attributes that can be used to search the model
     *
     * @var array
     */
    protected $searchFields = ['name'];

    /**
     * The attributes that the model can be sorted by
     *
     * @var array
     */
    protected $sortingFields = ['name'];
}
