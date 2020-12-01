<?php

namespace App\Api\Accounts\Http\Controllers;

use App\Api\Accounts\Models\User;
use App\Api\Accounts\Resources\UserResource;
use App\Api\Core\Http\Controllers\BaseController;

/**
 * Class UsersController
 * @package App\Api\Accounts\Http\Controllers
 */
class UsersController extends BaseController
{
    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->model = resolve(User::class);
        $this->resource = UserResource::class;
    }

    /**
     * Gets the current logged in user
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function current()
    {
        try {
            return new $this->resource(auth()->user());
        } catch (\Throwable $e) {
            return response()->json([
                'm' => $e->getMessage(),
                'l' => $e->getLine(),
                'f' => $e->getFile(),
            ], 400);
        }
    }
}
