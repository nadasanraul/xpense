<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\DefaultHidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class BaseModel
 * @property integer $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @package App\Models
 */
class BaseModel extends Model
{
    use DefaultHidden;

    /**
     * The attributes that the model can be filtered by
     *
     * @var array
     */
    protected $filterFields = [];

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

    public function getSearchFields()
    {
        return $this->searchFields;
    }

    public function getSortingFields()
    {
        return $this->sortingFields;
    }

    public function getFilterFields()
    {
        return $this->filterFields;
    }

    public function scopeSearchOn(Builder $query, array $searchData)
    {
        foreach ($searchData as $key => $data) {
            $query->orWhere($key, 'LIKE', '%' . $data . '%');
        }
    }
}
