<?php

namespace App\Api\Banks\Http\Controllers;

use App\Api\Banks\Models\Account;
use App\Api\Banks\Resources\AccountResource;
use App\Api\Core\Http\Controllers\BaseController;
use App\Api\Banks\Repositories\AccountRepository;

/**
 * Class AccountsController
 * @package App\Api\Banks\Http\Controllers
 */
class AccountsController extends BaseController
{
    /**
     * BanksController constructor.
     */
    public function __construct()
    {
        $this->model = resolve(Account::class);
        $this->repository = resolve(AccountRepository::class);
        $this->resource = AccountResource::class;
        $this->saveRules = [
            'name' => 'required|string|max:200',
            'description' => 'required|string|max:1000',
            'balance' => 'required|integer',
            'number' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'bank_id' => 'required|exists:banks,id',
        ];
    }
}
