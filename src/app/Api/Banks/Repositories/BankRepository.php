<?php

namespace App\Api\Banks\Repositories;

use App\Api\Banks\Models\Bank;

/**
 * Class BankRepository
 * @package App\Api\Banks\Repositories
 */
class BankRepository
{
    public static function collection(array $searchData = [])
    {
        return Bank::searchOn($searchData)->get();
    }
}
