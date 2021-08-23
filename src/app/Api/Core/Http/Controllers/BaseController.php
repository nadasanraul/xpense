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
use App\Api\Core\Handlers\ListHandlerInterface;
use App\Api\Core\Exceptions\InputValidatorException;

/**
 * Class BaseController
 * @package App\Api\Core\Http\Controllers
 */
abstract class BaseController extends Controller
{
    use HasQueryString;

    /**
     * @var string
     */
    protected $module;

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

    protected $operations = [];

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        foreach ($this->operations as $operation) {
            switch ($operation) {
                case 'list':
                    app()->bind(
                        ListHandlerInterface::class,
                        'App\\' . $this->module . '\Http\Resources' . $this->resource . 'ListHandler'
                    );
                    break;
            }
        }
    }

    /**
     * Getting a list of models
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(ListHandlerInterface $handler)
    {
        try {
            return $handler->list();
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
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function single()
    {
        try {
            $item = $this->repository->single(request()->route()->parameter('uuid'));

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
