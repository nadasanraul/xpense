<?php

namespace App\Api\Core\Http\Controllers;

use Throwable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Traits\HasQueryString;
use Illuminate\Routing\Controller;
use App\Api\Core\Models\BaseModel;
use Illuminate\Support\Facades\Validator;
use App\Api\Core\Repositories\BaseRepository;
use App\Api\Core\Exceptions\InputValidatorException;

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
     * @var array
     */
    protected $saveRules;

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

    /**
     * Getting a single model
     *
     * @param string $uuid
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
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

    /**
     * Creating a model
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function create()
    {
        try {
            $data = request()->all();
            $data['uuid'] = Str::uuid()->toString();

            $validator = Validator::make($data, $this->saveRules);
            if ($validator->fails()) {
                throw new InputValidatorException($validator->getMessageBag());
            }
            $item = $this->model->create($data);

            return new $this->resource($item);
        } catch (InputValidatorException $e) {
            return response()->json([
                'errors' => $e->errors,
            ], 400);
        } catch (Throwable $e) {
            return response()->json([
                'm' => $e->getMessage(),
                'l' => $e->getLine(),
                'f' => $e->getFile(),
            ], 400);
        }
    }

    /**
     * Updating a model
     *
     * @param string $uuid
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update(string $uuid)
    {
        try {
            $data = request()->all();

            $validator = Validator::make($data, $this->saveRules);
            if ($validator->fails()) {
                throw new InputValidatorException($validator->getMessageBag());
            }

            $item = $this->model->where('uuid', $uuid)->firstOrFail();
            $item->update($data);

            return new $this->resource($item);
        } catch (InputValidatorException $e) {
            return response()->json([
                'errors' => $e->errors,
            ], 400);
        } catch (Throwable $e) {
            return response()->json([
                'm' => $e->getMessage(),
                'l' => $e->getLine(),
                'f' => $e->getFile(),
            ], 400);
        }
    }

    /**
     * Deleting a model
     *
     * @param string $uuid
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(string $uuid)
    {
        try {
            $this->model->where('uuid', $uuid)->delete();

            return response()->json([], 204);
        } catch (Throwable $e) {
            return response()->json([
                'm' => $e->getMessage(),
                'l' => $e->getLine(),
                'f' => $e->getFile(),
            ], 400);
        }
    }
}
