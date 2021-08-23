<?php

namespace App\Core\Classes;

use Illuminate\Support\Arr;

use App\Exceptions\InvalidQueryParamException;

/**
 * Class RequestParser
 * @package App\Traits
 */
class RequestParser
{
    /**
     * Parsing the query string params
     *
     * @param array $params
     * @param       $class
     *
     * @return QueryBuilderDTO
     * @throws InvalidQueryParamException
     */
    public static function parseQueryString(array $params, $class): QueryBuilderDTO
    {
        $dto = new QueryBuilderDTO();

        foreach ($params as $key => $param) {
            switch ($key) {
                case 'sort':
                    foreach ($param as $column => $direction) {
                        if (!in_array($column, $class::$sortable)) {
                            throw new InvalidQueryParamException('Invalid sort params: ' . $column);
                        }

                        Arr::set($dto->sort, $column, $direction);
                    }
                    break;
                case 'fields':
                    $dto->fields = explode(',', $param);
                    break;
                case 'limit':
                    $dto->limit = $param;
                    break;
                case 'page':
                    break;
                default:
                    if (!in_array($key, $class::$searchable) || in_array($key, $class::$sensitive)) {
                        throw new InvalidQueryParamException('Invalid search params: ' . $key);
                    }
                    if ($param === ':null') {
                        $param = null;
                    }
                    if (is_array($param)) {
                        foreach ($param as $operator => $value) {
                            Arr::set(
                                $dto->search[$key],
                                $operator,
                                $operator === 'in' ? explode(',', $value) : $value
                            );
                        }
                    } else {
                        Arr::set(
                            $dto->search,
                            $key,
                            $param
                        );
                    }
            }
        }

        return $dto;
    }

    /**
     * Parsing the search params
     *
     * @param array $params
     * @param       $class
     *
     * @return QueryBuilderDTO
     * @throws InvalidQueryParamException
     */
    public static function parseSearch(array $params, $class)
    {
        $dto = new QueryBuilderDTO();

        foreach ($params as $key => $param) {
            switch ($key) {
                case 'sort':
                    foreach ($param as $column => $direction) {
                        if (!in_array($column, $class::$sortable)) {
                            throw new InvalidQueryParamException('Invalid sort params: ' . $column);
                        }

                        Arr::set($dto->sort, $column, $direction);
                    }
                    break;
                case 'fields':
                    $dto->fields = $param;
                    break;
                case 'limit':
                    $dto->limit = $param;
                    break;
                case 'page':
                    break;
                default:
                    if (!in_array($key, $class::$searchable)) {
                        throw new InvalidQueryParamException('Invalid search params: ' . $key);
                    }

                    if (gettype($param) === 'array') {
                        foreach ($param as $operator => $value) {
                            Arr::set($dto->search[$key], $operator, $value);
                        }
                    } else {
                        Arr::set($dto->search, $key, $param);
                    }
            }
        }

        return $dto;
    }
}
