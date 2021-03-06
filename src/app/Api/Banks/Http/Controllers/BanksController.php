<?php

namespace App\Api\Banks\Http\Controllers;

use App\Api\Banks\Models\Bank;
use App\Api\Banks\Resources\BankResource;
use App\Api\Banks\Repositories\BankRepository;
use App\Api\Core\Http\Controllers\BaseController;

/**
 * Class BanksController
 * @package App\Api\Banks\Http\Controllers
 */
class BanksController extends BaseController
{
    /**
     * BanksController constructor.
     */
    public function __construct()
    {
        $this->model = resolve(Bank::class);
        $this->repository = resolve(BankRepository::class);
        $this->resource = BankResource::class;
        $this->saveRules = [
            'name' => 'required|string|max:200',
            'description' => 'required|string|max:1000',
            'country' => 'required|string|min:2|max:2',
        ];
    }
}
