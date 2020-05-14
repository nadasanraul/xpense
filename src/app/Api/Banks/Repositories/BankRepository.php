<?php

namespace App\Api\Banks\Repositories;

use App\Api\Banks\Models\Bank;
use App\Api\Core\Repositories\BaseRepository;

/**
 * Class BankRepository
 * @package App\Api\Banks\Repositories
 */
class BankRepository extends BaseRepository
{
    /**
     * BankRepository constructor.
     *
     * @param Bank $model
     */
    public function __construct(Bank $model)
    {
        parent::__construct($model);
    }
}
