<?php

namespace App\Api\Banks\Repositories;

use App\Api\Banks\Models\Account;
use App\Api\Core\Repositories\BaseRepository;

/**
 * Class AccountRepository
 * @package App\Api\Banks\Repositories
 */
class AccountRepository extends BaseRepository
{
    /**
     * BankRepository constructor.
     *
     * @param Account $model
     */
    public function __construct(Account $model)
    {
        parent::__construct($model);
    }
}
