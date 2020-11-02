<?php

namespace App\Api\Banks\Http\Controllers;

use Throwable;
use App\Api\Banks\Models\Transaction;
use App\Api\Core\Http\Controllers\BaseController;
use App\Api\Banks\Resources\AccountTransactionResource;
use App\Api\Banks\Repositories\AccountTransactionsRepository;

/**
 * Class AccountTransactionsController
 * @package App\Api\Banks\Http\Controllers
 */
class AccountTransactionsController extends BaseController
{
    /**
     * AccountTransactionsController constructor.
     */
    public function __construct()
    {
        $this->model = resolve(Transaction::class);
        $this->repository = resolve(AccountTransactionsRepository::class);
        $this->resource = AccountTransactionResource::class;
        $this->saveRules = [
            'title' => 'required|string|max:200',
            'amount' => 'required|integer',
            'type' => 'required|in:add,sub',
            'completed_at' => 'required|string',
        ];
    }

    /**
     * Getting a single model
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function single()
    {
        try {
            $item = $this->repository->single(request()->route()->parameter('transactionUuid'));

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
     * Updating a model
     *
     * @param string $uuid
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update(string $uuid)
    {
        $uuid = request()->route()->parameter('transactionUuid');
        return parent::update($uuid);
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
        $uuid = request()->route()->parameter('transactionUuid');
        return parent::delete($uuid);
    }
}
