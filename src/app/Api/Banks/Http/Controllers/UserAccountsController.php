<?php

namespace App\Api\Banks\Http\Controllers;

use Illuminate\Http\Request;
use App\Api\Banks\Models\Account;
use App\Api\Banks\Resources\UserAccountResource;
use App\Api\Core\Http\Controllers\BaseController;
use App\Api\Core\Exceptions\ForbiddenAccessException;
use App\Api\Banks\Repositories\UserAccountsRepository;

/**
 * Class UserAccountsController
 * @package App\Api\Banks\Http\Controllers
 */
class UserAccountsController extends BaseController
{
    /**
     * UserAccountsController constructor.
     */
    public function __construct()
    {
        $this->middleware(function (Request $request, $next) {
            try {
                if ($request->route()->parameter('userUuid') !== auth()->user()->uuid) {
                    throw new ForbiddenAccessException('Access to this resource is not permitted');
                }

                return $next($request);
            }catch (ForbiddenAccessException $e) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], 403);
            } catch (\Throwable $e) {
                return response()->json([
                    'message' => 'Something went wrong. Please try again',
                ], 400);
            }
        });
        $this->model = resolve(Account::class);
        $this->repository = resolve(UserAccountsRepository::class);
        $this->resource = UserAccountResource::class;
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
