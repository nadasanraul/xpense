<?php

namespace App\Api\Core\Models;

use Carbon\Carbon;
use App\Traits\DefaultHidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class BaseModel
 * @property integer $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method searchOn(array $searchData)
 * @method sortBy(array $searchData)
 * @package App\Api\Core\Models
 */
abstract class BaseModel extends Model
{
    use DefaultHidden;

    /**
     * The attributes that can be used to search the model
     *
     * @var array
     */
    protected $searchFields = [];

    /**
     * The attributes that the model can be sorted by
     *
     * @var array
     */
    protected $sortingFields = [];

    /**
     * Getting the search fields for the model
     *
     * @return array
     */
    public function getSearchFields()
    {
        return $this->searchFields;
    }

    /**
     * Getting the sort fields for the model
     *
     * @return array
     */
    public function getSortingFields()
    {
        return $this->sortingFields;
    }

    /**
     * Search scope method on the model
     *
     * @param Builder $query
     * @param array   $searchData
     *
     * @return void
     */
    public function scopeSearchOn(Builder $query, array $searchData)
    {
        foreach ($searchData as $key => $data) {
            $query->orWhere($key, 'LIKE', '%' . $data . '%');
        }
    }

    /**
     * Sort scope method on the model
     *
     * @param Builder $query
     * @param array   $sortData
     *
     * @return void
     */
    public function scopeSortBy(Builder $query, array $sortData)
    {
        foreach ($sortData as $key => $value) {
            $query->orderBy($key, $value);
        }
    }
}
