<?php

namespace App\Api\Core\Repositories;

use App\Api\Core\Models\BaseModel;

/**
 * Class BaseRepository
 * @package App\Api\Core\Repositories
 */
abstract class BaseRepository
{
    /**
     * @var BaseModel
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param BaseModel $model
     */
    public function __construct(BaseModel $model)
    {
        $this->model = $model;
    }

    /**
     * Returns a collection of models
     *
     * @param array $searchData
     * @param array $sortData
     *
     * @return mixed
     */
    public function collection(array $searchData = [], array $sortData = [])
    {
        return $this->model->searchOn($searchData)->sortBy($sortData)->get();
    }
}
