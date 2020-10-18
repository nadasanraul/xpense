<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use App\Api\Core\Models\BaseModel;
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
            $search = array_filter($queryParams, function ($item) use ($model) {
                return $item !== 'sort';
            }, ARRAY_FILTER_USE_KEY);
        }

        if (isset($queryParams['sort'])) {
            $sort = [];
            foreach (explode(',', $queryParams['sort']) as $sortItem) {
                list($column, $direction) = explode(' ', $sortItem);
                $sort[$column] = $direction;
            }

            $invalidParams = array_diff(array_keys($sort), array_merge($model->getSortingFields()));
            if (count($invalidParams) > 0) {
                throw new InvalidQueryParamException('Invalid sort params: ' . implode(', ', $invalidParams));
            }

            $params['sort'] = $sort;
        }

        $invalidParams = array_diff(array_keys($search), array_merge($model->getSearchFields()));
        if (count($invalidParams) > 0) {
            throw new InvalidQueryParamException('Invalid search params: ' . implode(', ', $invalidParams));
        }

        $params['search'] = $search;

        return $params;
    }
}
