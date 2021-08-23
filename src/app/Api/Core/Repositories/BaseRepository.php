<?php

namespace App\Api\Core\Repositories;

use App\Api\Core\Models\BaseModel;
use App\Core\Classes\QueryBuilderDTO;
use Illuminate\Database\Eloquent\Model;

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
     * @param QueryBuilderDTO $dto
     *
     * @return mixed
     */
    public function collection(QueryBuilderDTO $dto)
    {
        $query = isset($dto->query) ? $dto->query : $this->model;

        $query = $query->filterOn($dto->search)->sortBy($dto->sort);
        return isset($dto->limit) ? $query->paginate($dto->limit) : $query->get();
    }

    /**
     * Gets a single resource
     *
     * @param string $uuid
     *
     * @return mixed
     */
    public function single(string $uuid, QueryBuilderDTO $dto)
    {
        $query = isset($dto->query) ? $dto->query : $this->model;

        return $query->filterOn($dto->search)
            ->where($this->model->getTable() . '.uuid', $uuid)
            ->first();
    }

    /**
     * Creates a model
     *
     * @param array  $data
     *
     * @return Model
     */
    public function create(array $data = [])
    {
        $model = $this->model->create($data);

        return $this->single($model->uuid, new QueryBuilderDTO());
    }

    /**
     * Updates a model
     *
     * @param string          $uuid
     * @param QueryBuilderDTO $dto
     * @param array           $data
     *
     * @return mixed
     */
    public function update(string $uuid, QueryBuilderDTO $dto, array $data = [])
    {
        $model = $this->single($uuid, $dto);
        $model->update($data);

        return $model;
    }

    /**
     * Deletes a model
     *
     * @param string          $uuid
     * @param QueryBuilderDTO $dto
     *
     * @return void
     */
    public function delete(string $uuid, QueryBuilderDTO $dto)
    {
        $model = $this->single($uuid, $dto);
        $model->delete();
    }
}
