<?php

namespace App\Api\Core\Http\Controllers;

use Throwable;
use Illuminate\Support\Arr;
use App\Traits\HasQueryString;
use Illuminate\Routing\Controller;
use App\Api\Core\Models\BaseModel;
use App\Api\Core\Repositories\BaseRepository;

/**
 * Class BaseController
 * @package App\Api\Core\Http\Controllers
 */
abstract class BaseController extends Controller
{
    use HasQueryString;

    /**
     * @var BaseModel
     */
    protected $model;

    /**
     * @var BaseRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $resource;

    /**
     * Getting a list of models
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        try {
            $queryStringArray = request()->query();

            $params = $this->parseQueryParams($queryStringArray, $this->model);
            $searchData = Arr::get($params, 'search', []);
            $sortData = Arr::get($params, 'sort', []);

            $collection = $this->repository->collection($searchData, $sortData);
            return $this->resource::collection($collection);
        } catch (Throwable $e) {
            return response()->json([
                'm' => $e->getMessage(),
                'l' => $e->getLine(),
                'f' => $e->getFile(),
            ], 400);
        }
    }

    public function single(string $uuid)
    {
        try {
            $item = $this->repository->single($uuid);

            return new $this->resource($item);
        } catch (Throwable $e) {
            return response()->json([
                'm' => $e->getMessage(),
                'l' => $e->getLine(),
                'f' => $e->getFile(),
            ], 400);
        }
    }
}
