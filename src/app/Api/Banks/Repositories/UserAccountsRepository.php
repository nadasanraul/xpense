<?php

namespace App\Api\Banks\Repositories;

use App\Api\Banks\Models\Account;
use App\Api\Accounts\Models\User;
use App\Api\Core\Repositories\BaseRepository;

/**
 * Class UserAccountsRepository
 * @package App\Api\Banks\Repositories
 */
class UserAccountsRepository extends BaseRepository
{
    /**
     * @var User
     */
    protected $user;

    /**
     * UserAccountsRepository constructor.
     *
     * @param Account $model
     */
    public function __construct(Account $model)
    {
        $userUuid = !is_null(request()->route()) ? request()->route()->parameter('userUuid') : null;
        $this->user = User::where('uuid', $userUuid)->first();
        parent::__construct($model);
    }

    public function collection(array $searchData = [], array $sortData = [])
    {
        $searchData['user_id'] = $this->user->id;
        return parent::collection($searchData, $sortData);
    }

    public function single(string $uuid)
    {
        return $this->model->where('uuid', $uuid)->where('user_id', $this->user->id)->first();
    }
}
