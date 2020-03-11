<?php

namespace App\Api\Banks\Http\Controllers;

use App\Models\BaseModel;
use Illuminate\Support\Arr;
use App\Api\Banks\Models\Bank;
use App\Traits\HasQueryString;
use Illuminate\Routing\Controller;
use App\Api\Banks\Repositories\BankRepository;

/**
 * Class BanksController
 * @package App\Api\Banks\Http\Controllers
 */
class BanksController extends Controller
{
    use HasQueryString;

    /**
     * @var BaseModel
     */
    protected $model;

    /**
     * BanksController constructor.
     */
    public function __construct()
    {
        /** @var BaseModel model */
        $this->model = resolve(Bank::class);
    }

    /**
     * Getting a list of banks
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        try {
            $queryStringArray = request()->query();

            $params = $this->parseQueryParams($queryStringArray, $this->model);
            $searchData = Arr::get($params, 'search', []);

            $banks = BankRepository::collection($searchData);
            return response()->json($banks, 200);
        } catch (\Throwable $e) {
            return response()->json($e->getMessage(), 400);
        }
    }
}
