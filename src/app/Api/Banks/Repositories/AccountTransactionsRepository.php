<?php

namespace App\Api\Banks\Repositories;

use App\Api\Banks\Models\Account;
use App\Api\Banks\Models\Transaction;
use App\Api\Core\Repositories\BaseRepository;

/**
 * Class AccountTransactionsRepository
 * @package App\Api\Banks\Repositories
 */
class AccountTransactionsRepository extends BaseRepository
{
    /**
     * @var Account
     */
    protected $account;

    /**
     * AccountTransactionsRepository constructor.
     *
     * @param Transaction $model
     */
    public function __construct(Transaction $model)
    {
        $accountUuid = !is_null(request()->route()) ? request()->route()->parameter('uuid') : null;
        $this->account = Account::where('uuid', $accountUuid)->first();
        parent::__construct($model);
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
        $searchData['account_id'] = $this->account->id;
        return parent::collection($searchData, $sortData);
    }

    /**
     * Gets a single resource
     *
     * @param string $uuid
     *
     * @return mixed
     */
    public function single(string $uuid)
    {
        return $this->model->where('uuid', $uuid)->where('account_id', $this->account->id)->first();
    }
}
