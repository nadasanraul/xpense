<?php

namespace App\Traits;

use App\Models\BaseModel;
use Illuminate\Support\Arr;
use App\Exceptions\InvalidQueryParamException;

/**
 * Trait HasQueryString
 * @package App\Traits
 */
trait HasQueryString
{
    /**
     * Getting the parsed query params
     *
     * @param array     $queryParams
     * @param BaseModel $model
     *
     * @return array
     */
    public function parseQueryParams(array $queryParams, BaseModel $model)
    {
        $params = [];
        if (in_array('q', array_keys($queryParams))) {
            $search = array_merge(...array_map(function($item) use ($queryParams) {
                return [$item => Arr::get($queryParams, 'q')];
            }, $model->getSearchFields()));
        } else {
            $search = $queryParams;
        }

        $invalidParams = array_diff(array_keys($search), $model->getSearchFields());
        if (count($invalidParams) > 0) {
            throw new InvalidQueryParamException('Invalid query params: ' . implode($invalidParams, ', '));
        }

        $params['search'] = $search;

        return $params;
    }
}
